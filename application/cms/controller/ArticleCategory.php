<?php

namespace app\cms\controller;

use app\common\controller\BaseController;
use app\common\entity\RequestEntity;

class ArticleCategory extends BaseController
{
    //设置数据表名
    const TABLE_NAME = 'cms_article_category_info';

    public function ListWithTree()
    {
        $get_page=input('Page',1);
        $get_pagesize=input('PageSize',10);
        $resultdata['TreeList']=parent::GetDataList(
        //设置表名
            $param_table_name = self::TABLE_NAME,
            //设置查询字段
            $param_field = [
                'id'                            => 'Id',
                'categoryinfo_name'             => 'Name',
                'categoryinfo_parentid'         => 'ParentId',
                'categoryinfo_userid'           => 'UserId',
            ],
            //设置查询条件
            $param_where = [
                'categoryinfo_isvalid' => 1,
                'categoryinfo_partnerid' => $this->USER_INFO['userinfo_partnerid'],
            ],
            //设置排序规则
            $param_order = [], $param_page = $get_page, $param_pagesize = $get_pagesize
        );
        $resultset_categoryinfo=parent::GetDataListWithTag(
        //设置表名
            $param_table_name = self::TABLE_NAME,
            //设置查询字段
            $param_field = [
                'id'                            => 'Id',
                'categoryinfo_name'             => 'Name',
                'categoryinfo_parentid'         => 'ParentId',
                'categoryinfo_partnerid'        => 'PartnerId',
                'categoryinfo_userid'           => 'UserId',
                'categoryinfo_description'      => 'Description',
            ],
            //设置查询条件
            $param_where = [
                'categoryinfo_isvalid' => 1,
                'categoryinfo_partnerid' => $this->USER_INFO['userinfo_partnerid'],
            ],
            //设置排序规则
            $param_order = [], $param_page = $get_page, $param_pagesize = $get_pagesize
        );
        $resultdata = array_merge($resultdata,$resultset_categoryinfo);
        return
            parent::ResponseJson(
                $resultdata,
                $param_message = ''
            );
    }
    /**
     * 数据列表
     * @return string
     */
    public function ListItem()
    {
        $get_page=input('Page',1);
        $get_pagesize=input('PageSize',10);
        $get_categoryid = input('ParentId');

        $where['categoryinfo_isvalid'] = 1;
        $where['categoryinfo_partnerid'] = $this->USER_INFO['userinfo_partnerid'];
        if($get_categoryid){
            $where['categoryinfo_parentid'] = $get_categoryid;
        }

        return
            parent::ResponseJson(
                parent::GetDataListWithTag(
                    //设置表名
                    $param_table_name = self::TABLE_NAME,
                    //设置查询字段
                    $param_field = [
                        'id'                            => 'Id',
                        'categoryinfo_name'             => 'Name',
                        'categoryinfo_parentid'         => 'ParentId',
                        'categoryinfo_partnerid'        => 'PartnerId',
                        'categoryinfo_userid'           => 'UserId',
                        'categoryinfo_description'      => 'Description',
                    ],
                    //设置查询条件
                    $param_where = $where,
                    //设置排序规则
                    $param_order = [], $param_page = $get_page, $param_pagesize = $get_pagesize
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
                parent::GetDataInfoWithTag(
                    //设置表名
                    $param_table_name = self::TABLE_NAME,
                    //设置查询字段
                    $param_field = [
                        'id'                            => 'Id',
                        'categoryinfo_parentid'         => 'ParentId',
                        'categoryinfo_partnerid'        => 'PartnerId',
                        'categoryinfo_userid'           => 'UserId',
                        'categoryinfo_name'             => 'Name',
                        'categoryinfo_description'      => 'Description',
                        'categoryinfo_content'          => 'Content',
                    ],
                    //设置查询条件
                    $param_where = [
                        'id' => $post_itemid->text,
                    ]
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
        //获取请求参数
        $post_itemid = new RequestEntity('ItemId', 'ID', true, 0);
        $post_parentid = new RequestEntity('Parentid', '姓名', true, 50);
        //验证表单内容
        $this->Validates($post_itemid);
        return
            parent::ResponseJson(
                parent::ModifyData(
                //设置表名
                    $param_table_name = self::TABLE_NAME,
                    //设置修改字段
                    $param_field = [
                        'categoryinfo_parentid' => $post_parentid->text
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
                    $param_table_name = self::TABLE_NAME,
                    $param_field = [
                        'id' => $post_itemid->text,
                        'categoryinfo_partnerid' => $this->USER_INFO['userinfo_partnerid'],
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
        $post_itemid = new RequestEntity('ItemId', 'ID', true, 0);
        //表单内容验证
        $this->Validates([$post_itemid]);
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

    /**
     * 查询一条数据
     * @param int $parentid 父类ID
     * @return string
     */
    public function TreeItem($parentid = 0)
    {
        //获取请求参数
        $post_parentid = new RequestEntity('parentid', 'ParentId', true, 0);
        //表单内容验证
        $this->Validates([$post_parentid]);
        return
            parent::ResponseJson(
                parent::GetDataInfoWithTag(
                //设置表名
                    $param_table_name = self::TABLE_NAME,
                    //设置查询字段
                    $param_field = [
                        'id'                            => 'Id',
                        'categoryinfo_name'             => 'Name',
                        'categoryinfo_parentid'         => 'ParentId',
                        'categoryinfo_partnerid'        => 'PartnerId',
                        'categoryinfo_userid'           => 'UserId',
                    ],
                    //设置查询条件
                    $param_where = [
                        'categoryinfo_parentid' => $parentid,
                    ]
                ),
                $param_message = ''
            );
    }
}