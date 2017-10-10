<?php

namespace app\common\extend;

use app\common\controller\BaseController;
use EasyWeChat\Foundation\Application;
use think\Db;

class WeChat extends BaseController
{
    const TABLE_NAME = 'partner_base_info';
    const MEMBER_TABLE_NAME = 'wechat_member_info';
    var $WECHAT_OPTION;
    var $WECHAT_PARTNER_ID;
    var $WECHAT_APP;

    public function __construct($param_partnerid, Request $request = null)
    {
        parent::__construct($request);
        $this->WECHAT_PARTNER_ID = $param_partnerid;
        $result = parent::GetDataInfo(
        //设置表名
            $param_table_name = self::TABLE_NAME,
            //设置查询字段
            $param_field = [
                'partnerinfo_wechat_appid' => 'AppId',
                'partnerinfo_wechat_appsecret' => 'AppSecret',
                'partnerinfo_wechat_token' => 'Token',
                'partnerinfo_wechat_aeskey' => 'AESKey'
            ],
            //设置查询条件
            $param_where = [
                'id' => $this->WECHAT_PARTNER_ID,
            ]
        );
        $this->WECHAT_OPTION = [
            'debug' => true,
            'app_id' => $result['AppId'],
            'secret' => $result['AppSecret'],
            'token' => $result['Token'],
            'aes_key' => $result['AESKey'],
            'log' => [
                'level' => 'debug',
                'file' => '/tmp/easywechat.log',
            ],
        ];
        $this->WECHAT_APP = new Application($this->WECHAT_OPTION);
    }

    public function BindServer()
    {
        $server = $this->WECHAT_APP->server;
        $server->setMessageHandler(function ($message) {
            switch ($message->MsgType) {
                case 'event':
                    $this->GetMemberInfo($message);
                    return '收到事件消息';
                    break;
                case 'text':
                    return '收到文本消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });
        $response = $this->WECHAT_APP->server->serve();
        // 将响应输出
        $response->send();
    }

    function GetMemberInfo($param_message)
    {
        $userService = $this->WECHAT_APP->user;
        $user = $userService->get($param_message->FromUserName);
        $member_info = parent::GetDataInfo(
        //设置表名
            $param_table_name = self::MEMBER_TABLE_NAME,
            //设置查询字段
            $param_field = [
                'id' => 'Id',
            ],
            //设置查询条件
            $param_where = [
                'wechatinfo_openid' => $user->openid,
            ]
        );

        if (empty($member_info)) {
            $field_data = [
                'wechatinfo_partnerid' => $this->WECHAT_PARTNER_ID,
                'wechatinfo_openid' => $user->openid,
                'wechatinfo_sex' => $user->sex,
                'wechatinfo_nickname' => $user->nickname,
                'wechatinfo_city' => $user->city,
                'wechatinfo_country' => $user->country,
                'wechatinfo_province' => $user->province,
                'wechatinfo_headimgurl' => $user->headimgurl,
                'wechatinfo_registertime' => $user->subscribe_time,
                'wechatinfo_groupid' => $user->groupid,
                'wechatinfo_tagidlist' => serialize($user->tagid_list)
            ];
            if (isset($user->unionid)) {
                $field_data['wechatinfo_unionid'] = $user->unionid;
            }
            parent::AddData(
                $param_table_name = self::MEMBER_TABLE_NAME,
                $param_field = $field_data
            );
        }
    }
}