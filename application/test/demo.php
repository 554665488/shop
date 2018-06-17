<?php
class Pool
{
    // 连接池数组
    protected $connections ;

    // 最大连接数
    //最大连接数:是连接池能申请的最大连接数,如果数据库连接请求超过次数,后面的数据库连接请求将被加入到等待队列中,这会影响以后的数据库操作
    protected $max ;

    // 最小连接数
    //最小连接数:是连接池一直保持的数据库连接,所以如果应用程序对数据库连接的使用量不大,将会有大量的数据库连接资源被浪费
    protected $min ;

    // 已连接数
    protected $count = 0 ;

    protected $inited = false ;

    // 单例
    private static $instance ;

    //数据库配置
    protected $config  = array(
        'host'       => '127.0.0.1',
        'port'       => 3306,
        'user'       => 'root',
        'password'   => 'root',
        'database'   => 'tp_shop',
        'charset'    => 'utf8',
        'timeout'    => 2,
    );

    public function __construct()
    {
    		/*
      		 队列是一种特殊的线性表，遵循先进先出原则，特殊之处在于它只允许在表的前端进行删除操作，
      		 而在表的后端进行插入操作和栈一样，队列是一种操作受限制的线性表。进行插入操作的端称为队尾，
      		 进行删除操作的端称为队头。队列中没有元素时，称为空队列。
    		*/
        //初始化连接是一个Spl队列-->SplQueue 类通过使用一个双向链表来提供队列的主要功能。php的扩展
        //http://php.net/manual/zh/class.splqueue.php
        $this->connections = new SplQueue() ; //连接池数实例化队列
        $this->max = 30 ;
        $this->min = 5 ;
        // 绑定单例
        self::$instance = & $this ;
    }

    //worker启动的时候 建立 min 个连接
    public function init()
    {
        if($this->inited){
            return ;
        }
        for($i = 0; $i < $this->min ; $i ++){
		      	// 调用建立一个新的连接88行
            $this->generate();
        }
        return $this ;
    }

    /**
     * 维持当前的连接数不断线，并且剔除断线的链接.
     */
    public function keepAlive()
    {
        // 2分钟检测一次连接，https://wiki.swoole.com/wiki/page/412.html
        swoole_timer_tick( 1000 , function(){
            // 维持连接
            while ($this->connections->count() >0 && $next=$this->connections->shift()){
                $next->query("select 1" , function($db ,$res){
                    if($res == false){
                        return ;
                    }
                    echo "当前连接数：" . $this->connections->count() . PHP_EOL ;
                    $this->connections->push($db);
                });
            }
        });

        swoole_timer_tick(1000 , function(){
            // 维持活跃的链接数在 min-max之间
            if($this->connections->count() > $this->max) {
                while($this->max < $this->connections->count()){
                    $next = $this->connections->shift();
                    $next->close();
                    $this->count-- ;
                    echo "关闭连接...\n" ;
                }
            }
        });
    }

    // 建立一个新的连接
    public function generate($callback = null)
    {
        $db = new swoole_mysql ; //https://wiki.swoole.com/wiki/page/517.html
        $db->connect($this->config , function($db , $res) use($callback) {
            if($res == false){
                throw new Exception("数据库连接错误::" . $db->connect_errno . $db->connect_error);
            }
            $this->count ++ ;
            //110行
            $this->addConnections($db);
            if(is_callable($callback)){
                call_user_func($callback);  //http://php.net/manual/zh/function.call-user-func.php
            }
        });
    }

    // 连接推进队列
    public function addConnections($db)
    {
        $this->connections->push($db);
        return $this;
    }

    //执行数据库命令 . 会判断连接数够不够，够就直接执行，不够就新建连接执行
    public function query($query , $callback)
    {
        if($this->connections->count() == 0) {
            $this->generate(function() use($query,$callback){
                $this->exec($query,$callback);
            });
        }else{
           $this->exec($query,$callback);
        }
    }
    // 直接执行数据库命令并且 callback();
    private function exec($query, $callback)
    {
        $db = $this->connections->shift();
        $db->query($query ,function($db , $result) use($callback){
            $this->connections->push($db);
            $callback($result);
        });
    }

    public static function getInstance()
    {
        if(is_null(self::$instance)){
            new Pool();
        }
        return self::$instance;
    }
}

$server = new swoole_http_server("0.0.0.0",9501);

$server->set([
    'worker_num' =>4,
]);
//
$server->on("WorkerStart",function($server , $wid){
    //执行init()函数，该函数主要是初始化连接池的数量为Pool::min的数量
    //执行keepAlive() , 该函数主要是用2个定时器，定时检查数据库连接的健康状态，以及连接数量的大小。具体多少时间可以根据业务来定。
    Pool::getInstance()->init()->keepAlive();
});


$server->on("request",function($request,$response){

    $pool = Pool::getInstance()->query("select * from users", function($res) use($response) {
        $response->end(json_encode($res));
    });

});
$server->start();
