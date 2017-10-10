<?php

namespace app\system\controller;

use app\common\controller\BaseController;
use app\common\entity\RequestEntity;
use app\common\entity\RequestFileEntity;

class Menu extends BaseController
{
    public function ListItem()
    {
        return
            parent::ResponseJson(
                parent::GetDataListWithTag(
                //设置数据表名称
                    $param_table_name = 'system_user_menu_info',
                    //设置字段名称
                    $param_field = [
                        'id' => 'Id',
                        'menuinfo_parentid' => 'ParentId',
                        'menuinfo_name' => 'Name',
                        'menuinfo_action' => 'Action',
                        'menuinfo_icon' => 'Icon',
                        'menuinfo_model' => 'Model',
                        'menuinfo_function' => 'Function',
                        'menuinfo_action' => 'Action',
                        'menuinfo_level' => 'Level',
                        'menuinfo_showorder' => 'Showorder',
                    ],
                    //设置查询条件
                    $param_where = [
                        'menuinfo_isvalid' => 1
                    ],
                    //设置排序规则
                    $param_order = 'menuinfo_showorder asc', $param_page = 0, $param_pagesize = 0
                ),
                $param_message = ''
            );
    }

    public function SaveMenu()
    {
        $post_title = new RequestEntity('Title', '名称', true, 100);
        $post_content = new RequestEntity('Content', '内容', false, 0);
        $post_time = new RequestEntity('Time', '时间', false, 10);
        $post_price = new RequestEntity('Price', '价格', true, 0);
        $post_price = new RequestFileEntity('Price', '价格', true, 0);
        //表单内容验证
        parent::Validates([$post_title, $post_content, $post_time, $post_price]);

        $post_title->text;

        dump($post_title);
    }
}
