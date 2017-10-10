<?php

namespace app\user\controller;

use app\common\entity\RequestEntity;
use app\common\extend\Tools;
use think\Db;

class Login
{
    const TABLE_NAME = 'system_user_info';

    public function Index()
    {
        $post_account = new RequestEntity('Account', '用户账号', true, 32);
        $post_password = new RequestEntity('Password', '用户密码', true, 32);
        if(empty($post_account->text)){
            $this->ResponseJson(null,'用户名不能为空');
        }
        if(empty($post_password->text)){
            $this->ResponseJson(null,'密码不能为空');
        }
        $resultset_userinfo = Db::table(self::TABLE_NAME)
            ->field([
                'id' => 'Id',
                'userinfo_account' => 'Account',
                'userinfo_nickname' => 'Nickname',
                'userinfo_name' => 'Name',
                'userinfo_sex' => 'Sex',
                'userinfo_phone' => 'Phone',
                'userinfo_createtime' => 'Createtime',
                'userinfo_token' => 'Token',
            ])
            ->where($param_where = [
                'userinfo_account' => $post_account->text,
                'userinfo_password' => md5($post_password->text),
                'userinfo_isvalid' => 1,
            ])
            ->find();
        if ($resultset_userinfo) {
            //生成Token
            $fields_userinfo['userinfo_token'] = Tools::GetToken($resultset_userinfo);
            $fields_userinfo['userinfo_token_expires'] = Tools::GetTimestamp(24);
            //获取登录IP
            $fields_userinfo['userinfo_ip'] = $this->GetIp();
            Db::table(self::TABLE_NAME)
                ->where($param_where = [
                    'id' => $resultset_userinfo['Id'],
                ])
                ->update($fields_userinfo);
        } else {
            $this->ResponseJson(null, '用户名或密码错误');
        }
        $resultset_userinfo['Token'] = $fields_userinfo['userinfo_token'];
        $resultset_userinfo['ip'] = $fields_userinfo['userinfo_ip'];
        $response_json['UserInfo'] = $resultset_userinfo;
        $this->ResponseJson($response_json);
    }

    /**
     * 响应数据请求，返回Json数据
     * @param null $param_items 待返回数据数组
     * @param string $param_message 数据状态说明
     * @return string
     */
    public function ResponseJson($param_items = null, $param_message = 'Error')
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

    /*
     * 获取用户ip地址
     */
    public function GetIp()
    {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";
        return ($ip);
    }
}
