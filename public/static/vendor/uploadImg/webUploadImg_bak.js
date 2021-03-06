/**
 * Created by 554665488 on 2018-6-3.
 */
// 图片上传demo
jQuery(function () {
    var $ = jQuery,    // just in case. Make sure it's not an other libaray.

        $wrap = $('#uploader'),

        // 图片容器
        $queue = $('<ul class="filelist"></ul>')
            .appendTo($wrap.find('.queueList')),

        // 状态栏，包括进度和控制按钮
        $statusBar = $wrap.find('.statusBar'),

        // 文件总体选择信息。
        $info = $statusBar.find('.info'),

        // 上传按钮
        $upload = $wrap.find('.uploadBtn'),

        // 没选择文件之前的内容。
        $placeHolder = $wrap.find('.placeholder'),

        // 总体进度条
        $progress = $statusBar.find('.progress').hide(),

        // 添加的文件数量
        fileCount = 0,

        // 添加的文件总大小
        fileSize = 0,

        // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,
        //上传错误信息
        fileError,
        // 缩略图大小
        thumbnailWidth = 110 * ratio,
        thumbnailHeight = 110 * ratio,

        // 可能有pedding, ready, uploading, confirm, done.
        state = 'pedding',

        // 所有文件的进度信息，key为file id
        percentages = {},

        supportTransition = (function () {
            var s = document.createElement('p').style,
                r = 'transition' in s ||
                    'WebkitTransition' in s ||
                    'MozTransition' in s ||
                    'msTransition' in s ||
                    'OTransition' in s;
            s = null;
            return r;
        })(),

        // WebUploader实例
        uploader;

    if (!WebUploader.Uploader.support()) {
        alert('Web Uploader 不支持您的浏览器！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
        throw new Error('WebUploader does not support the browser you are using.');
    }

    // 实例化
    uploader = WebUploader.create({
        pick: {
            // id: '#filePicker',
            // label: '点击选择图片'
        },
        dnd: '#uploader .queueList',
        paste: document.body,

        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },

        // swf文件路径
        swf: _static + '/plugin/webuploader-0.1.5/Uploader.swf',

        disableGlobalDnd: true,

        chunked: true,
        // server: 'http://webuploader.duapp.com/server/fileupload.php',
        server: urlConfig.goods.uploadGoodsImg,
        fileNumLimit: 5,
        fileSizeLimit: 5 * 1024 * 1024,    // 5 M
        fileSingleSizeLimit: 2 * 1024 * 1024    // 5 M
    });

    // 添加“添加文件”的按钮，
    uploader.addButton({
        id: '.filePicker',
        label: '选择文件'
    });

    // 当有文件添加进来时执行，负责view的创建
    function addFile(file) {
        // _console(file);
        var $li = $('<li id="' + file.id + '" class="diyUploadHover">' +
            '<p class="title">' + file.name + '</p>' +
            '<p class="imgWrap"></p>' +
            '<p class="progress"><span></span></p>' +
            '<p class="diyControl"><span class="diyLeft"><i></i></span><span class="diyRight"><i></i></span></p>'+
            '</li>'),

            $btns = $('<div class="file-panel">' +
                '<span class="cancel">删除</span>' +
                '<span class="rotateRight">向右旋转</span>' +
                '<span class="rotateLeft">向左旋转</span></div>').appendTo($li),
            $prgress = $li.find('p.progress span'),
            $wrap = $li.find('p.imgWrap'),
            $info = $('<p class="error"></p>'),

            showError = function (code) {
                switch (code) {
                    case 'exceed_size':
                        text = '文件大小超出';
                        break;

                    case 'interrupt':
                        text = '上传暂停';
                        break;

                    default:
                        text = '上传失败，请重试';
                        break;
                }

                $info.text(text).appendTo($li);
            };

        if (file.getStatus() === 'invalid') {
            showError(file.statusText);
        } else {
            // @todo lazyload
            $wrap.text('预览中');
            uploader.makeThumb(file, function (error, src) {
                if (error) {
                    $wrap.text('不能预览');
                    return;
                }

                var img = $('<img src="' + src + '">');
                $wrap.empty().append(img);
            }, thumbnailWidth, thumbnailHeight);

            percentages[file.id] = [file.size, 0];//保存用来计算进度条
            file.rotation = 0;
        }

        file.on('statuschange', function (cur, prev) {
            // _console(cur);
            // _console(prev);
            if (prev === 'progress') {
                $prgress.hide().width(0);
            } else if (prev === 'queued') {
                // $li.off('mouseenter mouseleave');//取消上传成功图片的删除旋转操作
                // $btns.remove();
            }

            // 成功
            if (cur === 'error' || cur === 'invalid') {
                // console.log(file.statusText);
                showError(file.statusText);
                percentages[file.id][1] = 1;
            } else if (cur === 'interrupt') { //中断
                showError('interrupt');
            } else if (cur === 'queued') {
                percentages[file.id][1] = 0;
            } else if (cur === 'progress') {
                $info.remove();
                $prgress.css('display', 'block');
            } else if (cur === 'complete') {
                $li.append('<span class="success"></span>');
            }

            $li.removeClass('state-' + prev).addClass('state-' + cur);
        });

        $li.on('mouseenter', function () {
            $btns.stop().animate({height: 30});
        });

        $li.on('mouseleave', function () {
            $btns.stop().animate({height: 0});
        });
        //绑定左移事件
        // _console($li.find('p.diyControl span.diyLeft'));
        $li.find('p.diyControl span.diyLeft').on('click',function(){
            leftLi($(this).parents('.diyUploadHover').prev(), $(this).parents('.diyUploadHover'));
        });
        //绑定右移事件
        $li.find('p.diyControl span.diyRight').on('click',function(){
            rightLi($(this).parents('.diyUploadHover').next(), $(this).parents('.diyUploadHover') );
        });
        $btns.on('click', 'span', function () {
            var index = $(this).index(),
                deg;

            switch (index) {
                case 0:
                    _console(file);
                    uploader.removeFile(file);  //如果上传成功删除预览图的时候删除服务器的图片
                    return;

                case 1:
                    file.rotation += 90;
                    break;

                case 2:
                    file.rotation -= 90;
                    break;
            }

            if (supportTransition) {
                deg = 'rotate(' + file.rotation + 'deg)';
                $wrap.css({
                    '-webkit-transform': deg,
                    '-mos-transform': deg,
                    '-o-transform': deg,
                    'transform': deg
                });
            } else {
                $wrap.css('filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation=' + (~~((file.rotation / 90) % 4 + 4) % 4) + ')');
                // use jquery animate to rotation
                // $({
                //     rotation: rotation
                // }).animate({
                //     rotation: file.rotation
                // }, {
                //     easing: 'linear',
                //     step: function( now ) {
                //         now = now * Math.PI / 180;

                //         var cos = Math.cos( now ),
                //             sin = Math.sin( now );

                //         $wrap.css( 'filter', "progid:DXImageTransform.Microsoft.Matrix(M11=" + cos + ",M12=" + (-sin) + ",M21=" + sin + ",M22=" + cos + ",SizingMethod='auto expand')");
                //     }
                // });
            }


        });

        $li.appendTo($queue);
    }
    //左移事件;
    function leftLi ($leftli, $li) {
        $li.insertBefore($leftli);
    }

    //右移事件;
    function rightLi ($rightli, $li) {
        $li.insertAfter($rightli);
    }
    // 负责view的销毁
    function removeFile(file) {
        var $li = $('#' + file.id);

        delete percentages[file.id];
        updateTotalProgress();
        $li.off().find('.file-panel').off().end().remove();
    }

    function updateTotalProgress() {
        var loaded = 0,
            total = 0,
            spans = $progress.children(),
            percent;
// _console(percentages);
        $.each(percentages, function (k, v) {
            total += v[0];
            loaded += v[0] * v[1];
        });
        // _console(total);
        // _console(loaded);
        percent = total ? loaded / total : 0;
        // _console(loaded / total);
        // _console(percent);
        spans.eq(0).text(Math.round(percent * 100) + '%');
        spans.eq(1).css('width', Math.round(percent * 100) + '%');
        updateStatus();
    }

    function updateStatus() {
        var text = '', stats;

        if (state === 'ready') {
            text = '选中' + fileCount + '张图片，共' +
                WebUploader.formatSize(fileSize) + '。';
        } else if (state === 'confirm') {
            stats = uploader.getStats();
            if (stats.uploadFailNum) {
                text = '已成功上传' + stats.successNum + '张照片至XX相册，' +
                    stats.uploadFailNum + '张照片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>';
                    // stats.uploadFailNum + '张照片上传失败'
            }

        } else {
            stats = uploader.getStats();
            text = '共' + fileCount + '张（' +
                WebUploader.formatSize(fileSize) +
                '），已上传' + stats.successNum + '张';

            if (stats.uploadFailNum) {
                text += '，失败' + stats.uploadFailNum + '张';
            }
        }

        $info.html(text);
    }

    function setState(val) {
        var file, stats;

        if (val === state) {
            return;
        }

        $upload.removeClass('state-' + state);
        $upload.addClass('state-' + val);
        state = val;
_console(state);
        switch (state) {
            case 'pedding': //删除预览图的时候执行
                // $placeHolder.removeClass('element-invisible');
                // $queue.parent().removeClass('filled');
                // $queue.hide();
                $statusBar.addClass('element-invisible');
                uploader.refresh();
                break;

            case 'ready'://预览成功的时候执行1
                // $placeHolder.addClass('element-invisible');
                // $('#filePicker2').removeClass('element-invisible');
                // $queue.parent().addClass('filled');
                // $queue.show();
                // $statusBar.removeClass('element-invisible');
                uploader.refresh();
                break;

            case 'uploading'://2
                // $('#filePicker2').addClass('element-invisible');
                $progress.show();
                $upload.text('暂停上传');
                break;

            case 'paused':
                $progress.show();
                $upload.text('继续上传');
                break;

            case 'confirm':///3
                $progress.hide();
                // $upload.text('开始上传').addClass('disabled');

                stats = uploader.getStats();
                if (stats.successNum && !stats.uploadFailNum) {
                    setState('finish');
                    return;
                }
                break;
            case 'finish'://4
                stats = uploader.getStats();

                if (stats.successNum) {
                    layer.msg('上传成功', {icon: 6})
                } else {
                    // 没有成功的图片，重设
                    state = 'done';
                    location.reload();
                }
                break;
        }

        updateStatus();
    }

    //当某个文件上传到服务端响应后，会派送此事件来询问服务端响应是否有效。如果此事件handler返回值为false, 则此文件将派送server类型的uploadError事件。
    uploader.onUploadAccept = function (object, ret) {

        if (ret.status == false) {
            fileError = ret.msg;
            return false;
        }
    };
    //上传成功返回的数据处理
    uploader.onUploadSuccess = function (file, response) {
        // console.log(response);
        if (response.status == true) {
            var div = document.getElementById('album_picture_id');//隐藏域存放的div
            // console.log(div);
            var o = document.createElement('input');
            o.setAttribute('type', 'hidden');
            o.setAttribute('name', 'album_picture_id[]');
            o.setAttribute('value', response.additional.album_picture_id);
            div.appendChild(o);
            return false;
        } else if (response.status == false) {
            layer.msg(response.msg);
        }

        // $('#'+file.id +' .bjy-filename').val(response.name)
    };
    uploader.onUploadError = function (file) {

        layer.msg(fileError)
    };
    uploader.onUploadProgress = function (file, percentage) {
        var $li = $('#' + file.id),
            $percent = $li.find('.progress span');

        $percent.css('width', percentage * 100 + '%');
        percentages[file.id][1] = percentage;

        updateTotalProgress();
    };

    uploader.onFileQueued = function (file) {
        fileCount++;
        fileSize += file.size;

        if (fileCount === 1) {
            // $placeHolder.addClass('element-invisible');//选择一张的图片的时候取消隐藏继续添加按钮
            $statusBar.show();
        }

        addFile(file);
        setState('ready');
        updateTotalProgress();
    };

    uploader.onFileDequeued = function (file) {//从队列中删除预览图
        fileCount--;
        fileSize -= file.size;

        if (!fileCount) {
            setState('pedding');
        }

        removeFile(file);
        updateTotalProgress();

    };

    uploader.on('all', function (type) {
        var stats;
        switch (type) {
            case 'uploadFinished':
                setState('confirm');
                break;

            case 'startUpload':
                setState('uploading');
                break;

            case 'stopUpload':
                setState('paused');
                break;

        }
    });

    uploader.onError = function (code) {
        if (code == 'F_DUPLICATE') {
            layer.msg('该图片已经被选择', {icon: 2});
            return false;
        }
        layer.msg('Eroor: ' + code, {icon: 2});
    };

    $upload.on('click', function () {
        if ($(this).hasClass('disabled')) {
            return false;
        }

        if (state === 'ready') {
            uploader.upload();
        } else if (state === 'paused') {
            uploader.upload();
        } else if (state === 'uploading') {
            uploader.stop();
        }
    });

    $info.on('click', '.retry', function () {
        uploader.retry();
    });

    $info.on('click', '.ignore', function () {
        alert('todo');
    });

    $upload.addClass('state-' + state);
    updateTotalProgress();
});