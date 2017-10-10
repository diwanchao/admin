<?php

namespace app\cms\controller;

use app\common\controller\BaseController;
use app\common\entity\RequestEntity;

class Article extends BaseController
{
    const TABLE_NAME = 'cms_article_info';
    const TREE_TABLE_NAME = 'cms_article_category_info';
    const AREA_TABLE_NAME = 'base_area_info';

    public function ListWithTree()
    {
        $post_parentid = input('ParentId');
        $where['articleinfo_isvalid'] = 1;
        $where['articleinfo_partnerid'] = $this->USER_INFO['userinfo_partnerid'];
        if(!empty($post_parentid)){
            $where['articleinfo_categoryid']=$post_parentid;
        }
        $resultdata['TreeList'] = parent::GetDataList(
        //设置表名
            $param_table_name = self::TREE_TABLE_NAME,
            //设置查询字段
            $param_field = [
                'id' => 'Id',
                'categoryinfo_name' => 'Name',
                'categoryinfo_parentid' => 'ParentId',
            ],
            //设置查询条件
            $param_where = [
                'categoryinfo_isvalid' => 1,
                'categoryinfo_partnerid' => $this->USER_INFO['userinfo_partnerid'],
            ],
            //设置排序规则
            $param_order = [], $param_page = 0, $param_pagesize = 0
        );
        $resultset_categoryinfo = parent::GetDataListWithTag(
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
            $param_page = input('Page', 1),
            $param_pagesize = input('PageSize', 10)
        );
        $resultdata = array_merge($resultdata, $resultset_categoryinfo);
        return
            parent::ResponseJson(
                $param_items = $resultdata,
                $param_message = ''
            );
    }

    /**
     * 数据列表
     * @return string
     */
    public function ListItem(){
        $request_data = [
            $get_keyword = new RequestEntity('Keyword', '搜索内容', false, 0)
        ];
        parent::Validates($request_data);
        if(!empty($get_keyword->text)){
            $where = "articleinfo_title like '%" . $get_keyword->text . "%' or articleinfo_keywords like '%" . $get_keyword->text . "%' or articleinfo_abstract like '%" . $get_keyword->text . "%'";
        }
        else{
            $post_parentid = input('ParentId');
            $where['articleinfo_isvalid'] = 1;
            $where['articleinfo_partnerid'] = $this->USER_INFO['userinfo_partnerid'];
            if(!empty($post_parentid)){
                $where['articleinfo_categoryid']=$post_parentid;
            }
        }
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
//        $key = input('Controls','Province');
//        $parentid = input('ParentId',100000);
        $resultset_articleinfo = parent::GetDataInfoWithTag(
        //设置表名
            $param_table_name = self::TABLE_NAME,
            //设置查询字段
            $param_field = [
                'id' => 'Id',
                'articleinfo_categoryid' => 'CategoryId',
                'articleinfo_title' => 'Title',
                'articleinfo_abstract' => 'Abstract',
                'articleinfo_keywords' => 'Keywords',
                'articleinfo_content' => 'Content',
                'articleinfo_imageurl' => 'Imageurl',
                'articleinfo_modifytime' => 'Modifytime',
                'articleinfo_createtime' => 'Createtime'
            ],
            //设置查询条件
            $param_where = [
                'id' => $post_itemid->text,
            ]
        );
        return
            parent::ResponseJson(
                $param_items = $resultset_articleinfo,
                $param_message = ''
            );
    }

    public function GetColumn ()
    {
        return
            parent::ResponseJson(
                parent::GetDataListWithTag(
                    $param_table_name = self::TREE_TABLE_NAME,
                    $param_field = [
                        'id' => 'Id',
                        'categoryinfo_name' => 'Name',
                        'categoryinfo_parentid' => 'ParentId',
                    ],
                    $param_where = [
                        'categoryinfo_isvalid' => 1,
                    ],
                    $param_order = [],
                    $param_page = input('Page', 1),
                    $param_pagesize = input('PageSize', 50)
                )
            );
    }

    public function GetArea(){
        $key = input('Controls','Province');
        $parentid = input('ParentId',100000);
        $resultdata[$key] = parent::GetDataList(
            $param_table_name = self::AREA_TABLE_NAME,
            $param_field = [
                'id' => 'Id',
                'areainfo_parentid' => 'ParentId',
                'areainfo_name' => 'Name',
                'areainfo_mergername' => 'MergerName',
                'areainfo_shortname' => 'ShortName'
            ],
            $param_where = [
                'areainfo_parentid' => $parentid,
            ],
            $param_order = [],
            $param_page = input('Page', 1),
            $param_pagesize = input('PageSize', 50)
        );
        parent::ResponseJson($resultdata,$param_message = '');
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
            $post_title = new RequestEntity('Title', '标题', true, 50),
            $post_abstract = new RequestEntity('Abstract', '摘要', true, 50),
            $post_content = new RequestEntity('Content', '内容', true, 10000),
            $post_keywords = new RequestEntity('Keywords', '关键词', true, 50),
            $post_categoryid = new RequestEntity('CategoryId', '上级栏目', true, 50),
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
                        'articleinfo_categoryid' => $post_categoryid->text,
                        'articleinfo_title' => $post_title->text,
                        'articleinfo_abstract' => $post_abstract->text,
                        'articleinfo_content' => $post_content->text,
                        'articleinfo_keywords' => $post_keywords->text,
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
            $post_title = new RequestEntity('Title', '标题', true, 50),
            $post_abstract = new RequestEntity('Abstract', '摘要', true, 50),
            $post_content = new RequestEntity('Content', '内容', true, 10000),
            $post_keywords = new RequestEntity('Keywords', '关键词', true, 50),
            $post_categoryid = new RequestEntity('CategoryId', '上级栏目', true, 50),
        ];
        //表单内容验证
        $this->Validates($request_data);
        return
            parent::ResponseJson(
                parent::AddData(
                    $param_table_name = self::TABLE_NAME,
                    $param_field = [
                        'articleinfo_title' => $post_title->text,
                        'articleinfo_abstract' => $post_abstract->text,
                        'articleinfo_content' => $post_content->text,
                        'articleinfo_categoryid' => $post_categoryid->text,
                        'articleinfo_keywords' => $post_keywords->text,
                        'articleinfo_partnerid' => $this->USER_INFO['userinfo_partnerid']

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