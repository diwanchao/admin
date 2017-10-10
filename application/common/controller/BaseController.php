<?php

namespace app\common\controller;

use app\common\entity\RequestEntity;
use think\Controller;
use think\Db;
use think\Request;

class BaseController extends Controller
{
    public $USER_INFO;

    public function _initialize()
    {
        parent::_initialize();
        $request_user_token = Request::instance()->header('UserToken');
        $this->ValidateToken($request_user_token);
        $this->USER_INFO = $this->GetDataInfo(
            $param_table_name = 'system_user_info',
            $param_field = [],
            $param_where = [
                'userinfo_token' => $request_user_token
            ]
        );
        if(!$this->USER_INFO){
            $this->ResponseJson(null,'Token验证失败，请重新登录');
        }
    }

    public function ValidateToken($param_token)
    {
        $request_param = [
            $header_token = new RequestEntity('', 'Token', true, 32),
        ];
        $header_token->text = $param_token;
        $this->Validates($request_param);
    }

    /**
     * 获取数据列表
     * @param string $param_table_name 数据表名
     * @param array $param_field 待获取字段数组
     * @param array $param_where 数据查询条件数组
     * @param array $param_order 数据排序数组
     * @param int $param_page 当前页数
     * @param int $param_pagesize 每页数据数量
     * @return array
     */
    public function GetDataList($param_table_name, $param_field, $param_where, $param_order, $param_page = 1, $param_pagesize = 20)
    {
        $resultset_iteminfos = Db::table($param_table_name)
            ->field($param_field)
            ->where($param_where)
            ->order($param_order)
            ->limit(($param_page - 1) * $param_pagesize, $param_pagesize)
            ->select();
        return $resultset_iteminfos;
    }

    /**
     * 获取数据列表
     * @param string $param_table_name 数据表名
     * @param array $param_field 待获取字段数组
     * @param array $param_where 数据查询条件数组
     * @param array $param_order 数据排序数组
     * @param int $param_page 当前页数
     * @param int $param_pagesize 每页数据数量
     * @return array
     */
    public function GetDataListWithTag($param_table_name, $param_field, $param_where, $param_order, $param_page = 1, $param_pagesize = 20)
    {
        $resultset_iteminfos = Db::table($param_table_name)
            ->field($param_field)
            ->where($param_where)
            ->order($param_order)
            ->limit(($param_page - 1) * $param_pagesize, $param_pagesize)
            ->select();
        $int_total_count = Db::table($param_table_name)
            ->where($param_where)
            ->count();
        $json_node = explode("_", $param_table_name);
        $return_data = array();
        sizeof($json_node) > 1 ?
            $string_tag = ucfirst($json_node[sizeof($json_node) - 2]) . ucfirst($json_node[sizeof($json_node) - 1]) :
            $string_tag = ucfirst($json_node[1]);
        $return_data[$string_tag]['TotalCount'] = $int_total_count;
        $return_data[$string_tag]['Page'] = (int)$param_page;
        $return_data[$string_tag]['PageSize'] = (int)$param_pagesize;
        $return_data[$string_tag]['Itemlist'] = $resultset_iteminfos;
        return $return_data;
    }

    /**
     * 获取单条信息
     * @param string $param_table_name 数据表名
     * @param array $param_field 待获取字段数组
     * @param array $param_where 数据查询条件数组
     * @return array|string
     */
    public function GetDataInfo($param_table_name, $param_field, $param_where)
    {
        return Db::table($param_table_name)
            ->field($param_field)
            ->where($param_where)
            ->find();
    }

    /**
     * 获取单条信息
     * @param string $param_table_name 数据表名
     * @param array $param_field 待获取字段数组
     * @param array $param_where 数据查询条件数组
     * @return array
     */
    public function GetDataInfoWithTag($param_table_name, $param_field, $param_where)
    {
        $resultset_iteminfos = Db::table($param_table_name)
            ->field($param_field)
            ->where($param_where)
            ->find();
        $json_node = explode("_", $param_table_name);
        $return_data = array();
        sizeof($json_node) > 1 ?
            $string_tag = ucfirst($json_node[sizeof($json_node) - 2]) . ucfirst($json_node[sizeof($json_node) - 1]) :
            $string_tag = ucfirst($json_node[1]);
        $return_data[$string_tag] = $resultset_iteminfos;
        return $return_data;
    }

    /**
     * @param string $param_table_name 数据表名
     * @param array $param_field 待获取字段数组
     * @param array $param_where 数据查询条件数组
     * @return
     */
    public function ModifyData($param_table_name, $param_field, $param_where)
    {
        return Db::table($param_table_name)
            ->where($param_where)
            ->update($param_field);
    }

    /**
     * @param string $param_table_name 数据表名
     * @param array $param_field 待获取字段数组
     * @return int|string
     */
    public function AddData($param_table_name, $param_field)
    {
        $bool_is_added = Db::table($param_table_name)
            ->insert($param_field);
        return $bool_is_added;
    }

    /**
     * @param string $param_table_name 数据表名
     * @param array $param_where 数据查询条件数组
     * @return int
     */
    public function RemoveData($param_table_name, $param_where)
    {
        $bool_is_removed = Db::table($param_table_name)
            ->where($param_where)
            ->delete();
        return $bool_is_removed;
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

    /**
     * 校验表单数据
     * @param array $param_objects 待校验数据数组
     */
    public function Validates($param_objects)
    {
        $array_data = [];
        $array_rule = [];
        for ($i = 0; $i < sizeof($param_objects); $i++) {
            $array_data[$param_objects[$i]->name] = $param_objects[$i]->text;
            if ($param_objects[$i]->isrequire === true) {
                $array_rule[$param_objects[$i]->name] = 'require';
            }
            if ($param_objects[$i]->length > 0) {
                if (!empty($array_rule[$param_objects[$i]->name])) {
                    $array_rule[$param_objects[$i]->name] .= '|' . 'max:' . $param_objects[$i]->length;
                } else {
                    $array_rule[$param_objects[$i]->name] = 'max:' . $param_objects[$i]->length;
                }
            }
            $result = $this->validate($array_data, $array_rule);
            if (true !== $result) {
                exit($this->ResponseJson(null, $result));
            }
        }
        return true;
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
