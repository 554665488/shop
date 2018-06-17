<?php
namespace app\test\controller;

use think\Controller;
use QRcodeUtil, Upload;
use Request, Log;
use app\common\Service;
use app\model\Goods;
// use Endroid\QrCode\ErrorCorrectionLevel;
// use Endroid\QrCode\LabelAlignment;
// use Endroid\QrCode\QrCode;
// use Endroid\QrCode\Response\QrCodeResponse;

/**
 * 商品类的测试类
 */
class Goodstest extends Controller
{



    private $goodService;
    public function initialize()
    {
        $this->goodService = Service::access(HOME_MODEL, 'GoodService');
    }
    /**
     * @route('getGoodsDetailTest')
     */
    public function getGoodsDetailTest()
    {
        return json(Service::access(HOME_MODEL, 'GoodService')->getGoodsDetail('383'));
    }

    public function getGoodsImagesTest()
    {
        return json($this->goodService->getGoodsImages('1844,1845,1846'));
    }

    public function categoryTest()
    {
        return dump(Service::access(HOME_MODEL, 'GoodsCategoryService')->getGoodsCategory());
    }
    /**
     * 测试图片上传
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function goodsPhotoUploadTest(Request $request)
    {
        $testPath = '\application\test\controller\\';
        Log::write($testPath);
        $file = $request::file('image');
        dump(Upload::fileUpload($file, $testPath, true));
        // 获取上传成功后的地址
        $path = Upload::getFilePath();
        // 上传之后的文件信息
        $imageName = Upload::getFileName();
        dump($path);
        dump($imageName);
        //获取表单上传文件
        // $file = $request::file('image');
        // Log::write($request::file());
        // //移动到框架应用根目录/public/uploads/ 目录下
        // $info = $file->validate([
        //       'size'   => 5000000,
        //       'ext'    => 'jpg,png,gif,jpeg'
        //       ])->move($testPath, false);
        // if ($info) {
        //     $this->success('文件上传成功');
        // } else {
        //     //上传失败获取错误信息
        //     $this->error($file->getError());
        // }
    }
    public function index()
    {
        return view();
    }
    public function goodslist()
    {
        return json(Goods::with('category_1')->select());
        // return json(Goods::with(['albumPicture' => function($query){
        //     $query->where('album_id = 31');
        // }] )->page(1, 20)->select());
    }


    public function textQrcode()
    {
        QRcodeUtil::setFile('application/test/controller');
        QRcodeUtil::getQRcode('111');
        // $qrCode = new QrCode('Life is too short to be generating QR codes');
        // $qrCode->setSize(300);
        //
        // // Set advanced options
        // $qrCode->setWriterByName('png');
        // $qrCode->setMargin(10);
        // $qrCode->setEncoding('UTF-8');
        // $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);
        // $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        // $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        // $qrCode->setLabel('Scan the code', 16, PROJECT_PATH.'/vendor/endroid/qrcode/assets/fonts/noto_sans.otf', LabelAlignment::CENTER);
        // $qrCode->setLogoPath(PROJECT_PATH.'/vendor/endroid/qrcode/assets/images/symfony.png');
        // $qrCode->setLogoWidth(150);
        // $qrCode->setRoundBlockSize(true);
        // $qrCode->setValidateResult(false);
        //
        // // Directly output the QR code
        // header('Content-Type: '.$qrCode->getContentType());
        // echo $qrCode->writeString();
        //
        // // Save it to a file
        // $qrCode->writeFile(PROJECT_PATH.'/qrcode.png');
    }
}
