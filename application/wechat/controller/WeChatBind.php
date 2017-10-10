<?php

namespace app\wechat\controller;

use app\common\entity\RequestEntity;
use app\common\extend\Tools;
use app\common\extend\WeChat;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;
use think\Controller;
use think\Db;

class WeChatBind extends Controller
{
    const TABLE_NAME = 'partner_base_info';
    var $PARTNER_ID;
    var $WECHAT;
    public function _initialize()
    {
        $post_partnerid = input('PartnerId','');
        if(empty($post_partnerid)){
            Tools::ResponseJson(null,'PartnerId不能为空！');
        }
        $this->PARTNER_ID = $post_partnerid;
        $this->WECHAT = new WeChat($post_partnerid);
    }

    /**
     * 关注微信公众平台及信息自动回复
     */
    public function Bind()
    {
        $this->WECHAT->BindServer();
    }
}