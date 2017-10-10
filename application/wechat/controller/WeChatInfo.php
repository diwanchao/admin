<?php

namespace app\wechat\controller;

use app\common\controller\BaseController;
use app\common\entity\RequestEntity;
use app\common\extend\Tools;
use app\common\extend\WeChat;

class WeChatInfo extends BaseController
{
    const TABLE_NAME = 'partner_base_info';
    /**
     * 详细信息
     * @return string
     */
    public function ItemInfo()
    {
        //获取请求参数
        $request_data = [
            $post_itemid = new RequestEntity('ItemId', 'ID', true, 0)
        ];
        //表单内容验证
        parent::Validates($request_data);
        $ItemId = $post_itemid->text;


        return
            parent::ResponseJson(
                parent::GetDataInfoWithTag(
                //设置表名
                    $param_table_name = self::TABLE_NAME,
                    //设置查询字段
                    $param_field = [
                        'partnerinfo_wechat_appid' => 'AppId',
                        'partnerinfo_wechat_appsecret' => 'AppSecret',
                        'partnerinfo_wechat_token' => 'Token',
                        'partnerinfo_wechat_aeskey' => 'AESKey',
                        'partnerinfo_wechat_signature' => 'Signature',      //签名
                        'partnerinfo_wechat_publickey' => 'PublicKey',      //公钥
                        'partnerinfo_wechat_privatekey' => 'PrivateKey',    //私钥
                        'partnerinfo_wechat_merchantid' => 'MerchantId'     //商户号
                    ],
                    //设置查询条件
                    $param_where = [
                        'id' => $ItemId,
                    ]
                )
            );

    }

    /**
     * 修改数据
     * @return string
     */
    public function ModifyItem()
    {
        //获取请求参数
        $request_data = [
            $post_itemid = new RequestEntity('ItemId', 'ID', true, 0),
            $post_appid = new RequestEntity('AppId', 'AppId', true, 50),
            $post_appsecret = new RequestEntity('AppSecret', 'AppSecret', true, 50),
            $post_token = new RequestEntity('Token', 'Token', true, 50),
            $post_aeskey = new RequestEntity('AESKey', 'EncodingAESKey', true, 50),
            $post_signature = new RequestEntity('Signature', 'EncodingAESKey', true, 50),
            $post_publickey = new RequestEntity('PublicKey', 'EncodingAESKey', true, 50),
            $post_privatekey = new RequestEntity('PrivateKey', 'EncodingAESKey', true, 50),
            $post_merchantid = new RequestEntity('MerchantId', 'EncodingAESKey', true, 50),
        ];
        //验证表单内容
        parent::Validates($request_data);
        return
            parent::ResponseJson(
                parent::ModifyData(
                //设置表名
                    $param_table_name = self::TABLE_NAME,
                    //设置修改字段
                    $param_field = [
                        'partnerinfo_wechat_appid' => $post_appid->text,
                        'partnerinfo_wechat_appsecret' => $post_appsecret->text,
                        'partnerinfo_wechat_token' => $post_token->text,
                        'partnerinfo_wechat_aeskey' => $post_aeskey->text,
                        'partnerinfo_wechat_signature' => $post_signature->text,      //签名
                        'partnerinfo_wechat_publickey' => $post_publickey->text,      //公钥
                        'partnerinfo_wechat_privatekey' => $post_privatekey->text,    //私钥
                        'partnerinfo_wechat_merchantid' => $post_merchantid->text     //商户号
                    ],
                    //设置查询条件
                    $param_where = [
                        'id' => $post_itemid->text,
                    ]
                )
            );
    }
}