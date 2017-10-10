<?php
namespace app\common\entity;

use app\common\extend\Tools;

class RequestFileEntity
{
    public $name;
    public $text;
    public $file;
    public $isrequire;
    public $length;
    public $size;
    public $filepath;

    /**
     * RequestFileEntity constructor.
     * @param $input
     * @param $name
     * @param $folder
     * @param $isrequire
     * @param $size
     */
    function __construct($input,$name,$folder,$isrequire,$size) {
        $this->file=$_FILES[$input];
        $this->name=$name;
        $this->isrequire=$isrequire;
        $this->size=$size;
        $this->filepath=Tools::FileUpload($input,$folder,$this->size);
        $this->text=$this->filepath;
    }
}
