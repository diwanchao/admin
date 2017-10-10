<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/26 0026
 * Time: 下午 4:58
 */
namespace app\wechat\controller;

use app\common\controller\BaseController;
use app\common\entity\RequestEntity;

class WeChatMenu extends BaseController
{
    const TABLE_NAME = 'wechat_menu_info';
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
                        'menuinfo_parentid' => 'ParentId',
                        'menuinfo_name' => 'Name',
                        'menuinfo_type' => 'Type',
                        'menuinfo_key' => 'Key',
                        'menuinfo_url' => 'Url',
                        'menuinfo_show' => 'Show'
                    ],
                    //设置查询条件
                    $param_where = [
                        'id' => $ItemId,
                    ]
                )
            );

    }

    /**
     * 数据列表
     * @return string
     */
    public function ListItem ()
    {
        return
            parent::ResponseJson(
                parent::GetDataListWithTag(
                //设置表名
                    $param_table_name = self::TABLE_NAME,
                    //设置查询字段
                    $param_field = [
                        'id' => 'Id',
                        'menuinfo_parentid' => 'ParentId',
                        'menuinfo_name' => 'Name',
                        'menuinfo_type' => 'Type',
                        'menuinfo_show' => 'Show',
                        'menuinfo_createtime' => 'CreateTime'
                    ],
                    //设置查询条件
                    $param_where = 'menuinfo_partnerid != 0 and menuinfo_partnerid = '.$this->USER_INFO['userinfo_partnerid'],
                    //设置排序规则
                    $param_order = [
                        'menuinfo_showorder' => 'desc'
                    ],
                    $param_page = $get_page = input('Page', 0),
                    $param_pagesize = input('PageSize', 0)
                ),
                $param_message = ''
            );
    }

    /**
     * 修改数据
     * @return string
     */
    public function ModifyItem()
    {
        $post_parentid = input('ParentId');
        //获取请求参数
        $request_data = [
            $post_itemid = new RequestEntity('ItemId', 'ID', true, 0),
            $post_name = new RequestEntity('Name', '菜单名称', true, 50),
            $post_type = new RequestEntity('Type', '按钮类型', true, 50),
            $post_key = new RequestEntity('Key', '关键词', false, 50),
            $post_url = new RequestEntity('Url', '跳转链接', false, 100),
            $post_show = new RequestEntity('Show', '是否显示', true, 50),
        ];
        //验证表单内容
        parent::Validates($request_data);
        if($post_parentid === '0'){
            parent::ModifyData(
            //设置表名
                $param_table_name = self::TABLE_NAME,
                //设置修改字段
                $param_field = [
                    'menuinfo_show' => $post_show->text
                ],
                //设置查询条件
                $param_where = [
                    'menuinfo_parentid' => $post_itemid->text,
                ]
            );
        }
        return
            parent::ResponseJson(
                parent::ModifyData(
                //设置表名
                    $param_table_name = self::TABLE_NAME,
                    //设置修改字段
                    $param_field = [
                        'menuinfo_name' => $post_name->text,
                        'menuinfo_type' => $post_type->text,
                        'menuinfo_key' => $post_key->text,
                        'menuinfo_url' => $post_url->text,
                        'menuinfo_show' => $post_show->text
                    ],
                    //设置查询条件
                    $param_where = [
                        'id' => $post_itemid->text,
                    ]
                )
            );
    }

    /**
     * 保存数据
     * @return string
     */
    public function AddItem()
    {
        //获取请求参数
        $request_data = [
            $post_parentid = new RequestEntity('ParentId', '父ID', true, 0),
            $post_name = new RequestEntity('Name', '菜单名称', true, 50),
            $post_type = new RequestEntity('Type', '按钮类型', true, 50),
            $post_key = new RequestEntity('Key', '关键词', false, 50),
            $post_url = new RequestEntity('Url', '跳转链接', false, 100),
            $post_show = new RequestEntity('Show', '是否显示', true, 50),
        ];
        //表单内容验证
        $this->Validates($request_data);
        return
            parent::ResponseJson(
                parent::AddData(
                    $param_table_name = self::TABLE_NAME,
                    $param_field = [
                        'menuinfo_parentid' => $post_parentid->text,
                        'menuinfo_name' => $post_name->text,
                        'menuinfo_type' => $post_type->text,
                        'menuinfo_key' => $post_key->text,
                        'menuinfo_url' => $post_url->text,
                        'menuinfo_show' => $post_show->text,
                        'menuinfo_isvalid' => 1,
                        'menuinfo_partnerid' => $this->USER_INFO['userinfo_partnerid'],
                    ]
                )
            );
    }

    /**
     * 删除表数据
     * @return string
     */
    public function RemoveItem()
    {
        //获取请求参数
        $request_data = [
            $post_itemid = new RequestEntity('ItemId', 'ID', true, 0)
        ];
        //表单内容验证
        $this->Validates($request_data);
        return
            parent::ResponseJson(
                parent::RemoveData(
                    $param_table_name = self::TABLE_NAME,
                    $param_where = [
                        'id' => $post_itemid->text,
                    ]
                )
            );
    }
}