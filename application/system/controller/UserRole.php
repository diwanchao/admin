<?php

namespace app\system\controller;

use app\common\controller\BaseController;
use app\common\entity\RequestEntity;

class UserRole extends BaseController
{
    const TABLE_NAME='system_user_role_info';

    /**
     * 数据列表
     * @return string
     */
    public function ListItem()
    {
        return
            parent::ResponseJson(
                parent::GetDataList(
                //设置数据表名称
                    $param_table_name = self::TABLE_NAME,
                    //设置字段名称
                    $param_field = [
                        'id' => 'Id',
                        'roleinfo_name' => 'Name',
                        'roleinfo_remark' => 'Remark',
                    ],
                    //设置查询条件
                    $param_where = [
                        'roleinfo_isvalid' => 1,
                        'roleinfo_issuper' => array('NEQ',1),
                        'roleinfo_partnerid' => $this->USER_INFO['userinfo_partnerid'],
                    ],
                    //设置排序规则
                    $param_order = [], $param_page = 0, $param_pagesize = 0
                ),
                $param_message = ''
            );
    }

    /**
     * 详细信息
     * @return string
     */
    public function ItemInfo()
    {
        //获取请求参数
        $post_itemid = new RequestEntity('ItemId', 'ID', true, 0);
        //表单内容验证
        parent::Validates([$post_itemid]);

        return
            parent::ResponseJson(
                parent::GetDataInfo(
                //设置数据表名称
                    $param_table_name = self::TABLE_NAME,
                    //设置字段名称
                    $param_field = [
                        'id' => 'Id',
                        'roleinfo_name' => 'Name',
                        'roleinfo_remark' => 'Remark',
                    ],
                    //设置查询条件
                    $param_where = [
                        'id' => $post_itemid->text
                    ]
                ),
                $param_message = ''
            );
    }

    /**
     * 修改数据
     * @return string
     */
    public function ModifyItem(){
        //获取请求参数
        $post_itemid = new RequestEntity('ItemId', 'ID', true, 0);
        $post_name = new RequestEntity('Name', '姓名', true, 20);
        //表单内容验证
        $this->Validates([$post_itemid]);
        return
            parent::ResponseJson(
                parent::ModifyData(
                //设置数据表名称
                    $param_table_name = self::TABLE_NAME,
                    //设置查询条件
                    $param_field = [
                        'name' => $post_name->text
                    ],
                    //设置查询条件
                    $param_where = [
                        'id' => $post_itemid->text
                    ]
                )
            );
    }

    /**
     * 保存数据
     * @return string
     */
    public function AddItem(){
        //获取请求参数
        $post_itemid = new RequestEntity('ItemId', 'ID', true, 0);
        $post_itemid = new RequestEntity('ItemId', 'ID', true, 0);
        $post_itemid = new RequestEntity('ItemId', 'ID', true, 0);
        $post_itemid = new RequestEntity('ItemId', 'ID', true, 0);
        $post_itemid = new RequestEntity('ItemId', 'ID', true, 0);
        $post_itemid = new RequestEntity('ItemId', 'ID', true, 0);
        $post_itemid = new RequestEntity('ItemId', 'ID', true, 0);

        //表单内容验证
        $this->Validates([$post_itemid]);
        return
            parent::ResponseJson(
                parent::AddData(
                //设置数据表名称
                    $param_table_name = self::TABLE_NAME,
                    //设置查询条件
                    $param_field = [
                        'id' => $post_itemid->text,
                        'roleinfo_partnerid' => $this->USER_INFO['userinfo_partnerid'],
                    ]
                )
            );
    }

    /**
     * 删除数据
     * @return string
     */
    public function RemoveItem(){
        //获取请求参数
        $post_itemid = new RequestEntity('ItemId', 'ID', true, 0);
        //表单内容验证
        $this->Validates([$post_itemid]);
        return
            parent::ResponseJson(
                parent::RemoveData(
                //设置数据表名称
                    $param_table_name = self::TABLE_NAME,
                    //设置查询条件
                    $param_where = [
                        'id' => $post_itemid->text
                    ]
                )
            );
    }
}
