<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/25 0025
 * Time: 下午 4:52
 */
namespace app\system\controller;

use app\common\extend\Tools;

class Common
{
    public function UploadFile ()
    {
        $url = input('Folder');
        $image_url['Image'] = Tools::FileUpload('file', $url, 5242880);
        Tools::ResponseJson($image_url,'');
    }
}
