<?php
namespace app\common\entity;

class RequestEntity
{
    public $name;
    public $text;
    public $file;
    public $isrequire;
    public $length;
    public $size;

    /**
     * RequestEntity constructor.
     * @param $input
     * @param $name
     * @param $isrequire
     * @param $length
     */
    function __construct($input,$name,$isrequire,$length) {
        $this->text=input($input);
        $this->name=$name;
        $this->isrequire=$isrequire;
        $this->length=$length;
    }
}
