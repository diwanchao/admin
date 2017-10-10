<?php

namespace app\cms\controller;

use app\common\controller\BaseController;
use app\common\entity\RequestEntity;

class Notice extends BaseController
{
    const TABLE_NAME = 'cms_notice_info';

    /**
     * 数据列表
     * @return string
     */
    public function ListItem(){
        return
            parent::ResponseJson(
                parent::GetDataListWithTag(
                //设置表名
                    $param_table_name = self::TABLE_NAME,
                    //设置查询字段
                    $param_field = [
                        'id' => 'Id',
                        'noticeinfo_partnerid' => 'PartnerId',
                        'noticeinfo_name' => 'Name',
                        'noticeinfo_description' => 'Description',
                        'noticeinfo_likenum' => 'LikeNum',
                        'noticeinfo_visitnum' => 'VisitNum',
                        'noticeinfo_isvalid' => 'Isvalid',
                        'noticeinfo_createtime' => 'CreateTime',
                        'noticeinfo_image' => 'Image',
                    ],
                    //设置查询条件
                    $param_where = [
                        'noticeinfo_isvalid' => 1,
                        'noticeinfo_partnerid' => $this->USER_INFO['userinfo_partnerid'],
                    ],
                    //设置排序规则
                    $param_order = [
                        'id' => 'asc'
                    ],
                    $param_page = $get_page = input('Page', 1),
                    $param_pagesize = input('PageSize', 1)
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
        $request_data = [
            $post_itemid = new RequestEntity('ItemId', 'ID', true, 0)
        ];
        //表单内容验证
        parent::Validates($request_data);
        return
            parent::ResponseJson(
                parent::GetDataInfoWithTag(
                //设置表名
                    $param_table_name = self::TABLE_NAME,
                    //设置查询字段
                    $param_field = [
                        'noticeinfo_partnerid' => 'PartnerId',
                        'noticeinfo_name' => 'Name',
                        'noticeinfo_description' => 'Description',
                        'noticeinfo_content' => 'Content',
                        'noticeinfo_likenum' => 'LikeNum',
                        'noticeinfo_visitnum' => 'VisitNum',
                        'noticeinfo_isvalid' => 'Isvalid',
                        'noticeinfo_showorder' => 'ShowOrder',
                        'noticeinfo_image' => 'Image',
                        'noticeinfo_createtime' => 'CreateTime',
                    ],
                    //设置查询条件
                    $param_where = [
                        'id' => $post_itemid->text,
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
            $post_name = new RequestEntity('Name', '公告标题', true, 50),
            $post_description = new RequestEntity('Description', '公告摘要', true, 50),
            $post_content = new RequestEntity('Content', '公告内容', true, 10000),
            $post_showorder = new RequestEntity('ShowOrder', '公告排序', true, 50),
            $post_image = new RequestEntity('Image', '图片', false, 0),
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
                        'noticeinfo_name' => $post_name->text,
                        'noticeinfo_description' => $post_description->text,
                        'noticeinfo_content' => $post_content->text,
                        'noticeinfo_showorder' => $post_showorder->text,
                        'noticeinfo_image' => $post_image->text,
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
            $post_name = new RequestEntity('Name', '公告标题', true, 50),
            $post_description = new RequestEntity('Description', '公告摘要', true, 50),
            $post_content = new RequestEntity('Content', '公告内容', true, 10000),
            $post_showorder = new RequestEntity('ShowOrder', '公告排序', true, 50),
            $post_image = new RequestEntity('Image', '图片', false, 0),
        ];
        //表单内容验证
        $this->Validates($request_data);
        return
            parent::ResponseJson(
                parent::AddData(
                    $param_table_name = self::TABLE_NAME,
                    $param_field = [
                        'noticeinfo_name' => $post_name->text,
                        'noticeinfo_description' => $post_description->text,
                        'noticeinfo_content' => $post_content->text,
                        'noticeinfo_showorder' => $post_showorder->text,
                        'noticeinfo_image' => $post_image->text,
                        'noticeinfo_partnerid' => $this->USER_INFO['userinfo_partnerid'],
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
    /**
     * 搜索数据列表
     */
    public function SearchData ()
    {
        $request_data = [
            $post_search_data = new RequestEntity('search_data', '搜索内容', true, 0)
        ];
        //表单内容验证
        $this->Validates($request_data);
        $where = "articleinfo_title like '%" . $post_search_data->text . "%' or articleinfo_keywords like '%" . $post_search_data->text . "%' or articleinfo_abstract like '%" . $post_search_data->text . "%'";
        return
            parent::ResponseJson(
                parent::GetDataListWithTag(
                //设置表名
                    $param_table_name = self::TABLE_NAME,
                    //设置查询字段
                    $param_field = [
                        'id' => 'Id',
                        'articleinfo_categoryid' => 'CategoryId',
                        'articleinfo_title' => 'Title',
                        'articleinfo_keywords' => 'Keywords',
                        'articleinfo_abstract' => 'Abstract',
                        'articleinfo_favoritenum' => 'FavoriteNum',
                        'articleinfo_smalltitle' => 'SmallTitle',
                        'articleinfo_imageurl' => 'Imageurl',
                        'articleinfo_modifytime' => 'Modifytime',
                        'articleinfo_createtime' => 'Createtime'
                    ],
                    //设置查询条件
                    $param_where = $where,
                    //设置排序规则
                    $param_order = [],
                    $param_page = $get_page = input('Page', 1),
                    $param_pagesize = input('PageSize', 1)
                ),
                $param_message = ''
            );
    }
}