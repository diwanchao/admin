<?php

namespace app\common\extend;

class Tools
{
    /**
     * 文件上传
     * @param $param_file
     * @param $param_folder
     */
    public static function FileUpload($param_file, $param_folder, $param_size)
    {
        $file = request()->file($param_file);
        if($file!=null){
            $file_info = $file->validate(['size'=>$param_size])->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . $param_folder);
            if (!$file_info) {
                exit(self::ResponseJson(null,$file->getError()));
            } else {
                self::ResizeImage($file_info->getRealPath(), "small", 100);
                self::ResizeImage($file_info->getRealPath(), "middle", 500);
                self::ResizeImage($file_info->getRealPath(), "large", 1000);
            }
            return DS . 'uploads' . DS . $param_folder.DS.$file_info->getSaveName();
        }
        return '';
    }

    /**
     * 图片缩放
     * @param $param_src
     * @param $param_folder
     * @param $param_width
     * @return string
     */
    public static function ResizeImage($param_src, $param_folder, $param_width)
    {
        $string_temp_path = pathinfo($param_src);
        $string_file_name = $string_temp_path["basename"];//文件名
        $string_file_dir = $string_temp_path["dirname"];//文件所在的文件夹
        $string_file_savepath = "{$string_file_dir}/$param_folder/{$string_file_name}";//缩略图保存路径,新的文件名为*.thumb.jpg
        if (!is_dir("{$string_file_dir}/$param_folder/")) {
            mkdir("{$string_file_dir}/$param_folder/");
        }
        //获取图片的基本信息
        $array_image_info = getimagesize($param_src);
        $image_width = $array_image_info[0];//获取图片宽度
        $image_height = $array_image_info[1];//获取图片高度
        $scaling = round($param_width / $image_width, 2);#缩放比例
        $image_current_width = $param_width;
        if ($scaling < 0) {
            $image_current_height = intval($image_height / $scaling);
        } else {
            $image_current_height = intval($image_height * $scaling);
        }
        $temp_image = imagecreatetruecolor($image_current_width, $image_current_height);//创建画布
        $current_image = null;
        switch ($array_image_info[2]) {
            case 1:
                $current_image = imagecreatefromgif($param_src);
                break;
            case 2:
                $current_image = imagecreatefromjpeg($param_src);
                break;
            case 3:
                $current_image = imagecreatefrompng($param_src);
                break;
        }
        imagecopyresampled($temp_image, $current_image, 0, 0, 0, 0, $image_current_width, $image_current_height, $image_width, $image_height);
        imagejpeg($temp_image, $string_file_savepath, 50);
        imagedestroy($current_image);
        return $string_file_savepath;
    }

    /**
     * 响应数据请求，返回Json数据
     * @param null $param_items 待返回数据数组
     * @param string $param_message 数据状态说明
     * @return string
     */
    public static function ResponseJson($param_items = null, $param_message = 'Error')
    {
        if (!isset($param_items)) {
            $array_result['State']['Code'] = 0;
            $array_result['State']['Message'] = $param_message;
            exit(json_encode($array_result));
        } else {
            if($param_items==1||$param_items==0){
                $array_result['State']['Code'] = 1;
                $array_result['State']['Message'] = 'Success';
                exit(json_encode($array_result));
            }
            else{
                $array_result['State']['Code'] = 1;
                $array_result['State']['Message'] = 'Success';
                exit(json_encode(array_merge($array_result, $param_items)));
            }
        }
    }

    /**
     * @param $param_userinfo
     * @return string
     */
    public static function GetToken($param_userinfo)
    {
        return MD5($param_userinfo['Id'] . $param_userinfo['Account'] . time());
    }

    /**
     * @param $param_userinfo
     * @return string
     */
    public static function GetTimestamp($param_hour)
    {
        return time() + $param_hour * 60 * 60;
    }
}