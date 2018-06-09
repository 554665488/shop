<?php
/**
 * Created by PhpStorm.
 * @description:
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Date: 2018-6-2
 * Time: 21:02
 */

namespace app\common;

use Endroid\QrCode\QrCode;

/**
 * @description:二维码生成工具
 * @time:
 * @Author: yfl
 * @QQ 554665488
 * Class QRcodeUtil
 * @package app\common
 */
class QRcodeUtil
{
    //二维码字体路径
    private $font = PROJECT_ROOT . 'vendor/endroid/qr-code/assets/noto_sans.otf';
    //logo图标地址
    private $logoPath = PROJECT_ROOT . 'vendor/endroid/qr-code/assets/symfony.png';
    //保存图片地址
    private $savePath = PROJECT_ROOT . '/public/upload/goods_qrcode';

    /**
     * @description:
     * @time: 2018年6月9日12:28:41
     * @Author: yfl
     * @QQ 554665488
     * @param string $data:放入二维码数据
     * @param string $prefix:二维码名称前缀
     * @param string $suffix:二维码名称后缀
     * @param string $text
     * @return bool|string
     * @throws \Endroid\QrCode\Exception\InvalidWriterException
     */
    public function make($data = '', $prefix = 'qrcode', $suffix = 'png', $text = '100')
    {
        if ($data == '') return false;
        $qrCode = new QrCode($data);
        $qrCode->setSize(300);
        $qrCode->setWriterByName($suffix);
        $qrCode->setMargin(10);
        $qrCode->setEncoding('UTF-8');
//        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
//        $qrCode->setLabel('Scan the code', 16, $this->font);
        $qrCode->setLabel($text, 16, $this->font);
//        $qrCode->setLogoPath($this->logoPath);
        $qrCode->setLogoWidth(150);
        $qrCode->setRoundBlockSize(true);
        $qrCode->setValidateResult(false);
        // Directly output the QR code
        header('Content-Type: ' . $qrCode->getContentType());
        //保存图片
        $saveQrcodeFile = $this->savePath . '/' . $prefix . time() .'_' .rand(10, 9999) . '.' . $suffix;
//        echo $qrCode->writeString();

        // Save it to a file
        $qrCode->writeFile($saveQrcodeFile);

        // Create a response object
//        $response = new QrCodeResponse($qrCode);
        return $saveQrcodeFile;
    }

    /**
     * @description:设置二维码保存路径
     * @time: 2018年6月2日21:16:56
     * @Author: yfl
     * @QQ 554665488
     * @param string $filePath
     */
    public function setSavePath($filePath = '')
    {
        $this->savePath = $filePath == '' ? $this->savePath : $filePath;
    }

    /**
     * @description:设置二维码logo
     * @time:2018年6月2日21:17:26
     * @Author: yfl
     * @QQ 554665488
     * @param $logoPath
     */
    public function setLogoPath($logoPath = '')
    {
        $this->logoPath = $logoPath == '' ? $this->logoPath : $logoPath;
    }

    /**
     * @description:设置二维码字体
     * @time:  2018年6月2日21:18:00
     * @Author: yfl
     * @QQ 554665488
     * @param $label
     */
    public function setLabel($font = '')
    {
        $this->font = $font == '' ? $this->font : $font;
    }
}