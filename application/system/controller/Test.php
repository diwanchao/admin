<?php

namespace app\system\controller;

use app\common\controller\BaseController;
use app\common\entity\RequestFileEntity;

class Test extends BaseController
{
    /**
     * 删除数据
     * @return string
     */
    public function Test()
    {
        //获取请求参数
        $request_param=[
            $post_idcard = new RequestFileEntity('idcard', '身份证图片', 'user/idcard',true, 1),
            $post_header = new RequestFileEntity('header', '用户头像','user/header', true, 1)
        ];
        parent::Validates($request_param);
    }
}
