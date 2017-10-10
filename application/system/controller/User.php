<?php

namespace app\system\controller;

use app\common\controller\BaseController;
use app\common\entity\RequestEntity;

class User extends BaseController
{
    const TABLE_NAME='system_user_info';

    /**
     * 数据列表
     * @return string
     */
    public function ListItem()
    {
        return
            parent::ResponseJson(
                parent::GetDataListWithTag(
                //设置表名
                    $param_table_name = 'view_system_role_user_info',
                    //设置查询字段
                    $param_field = [
                        'id' => 'Id',
                        'userinfo_roleid' => 'RoleId',
                        'userinfo_name' => 'Name',
                        'userinfo_nickname' => 'Nickname',
                        'userinfo_account' => 'Account',
                        'userinfo_sex' => 'Sex',
                        'userinfo_email' => 'Email',
                        'userinfo_phone' => 'Phone',
                        'userinfo_header' => 'Header',
                        'userinfo_showorder' => 'Showorder',
                        'roleinfo_name' => 'RoleName',
                    ],
                    //设置查询条件
                    $param_where = [
                        'userinfo_isvalid' => 1,
                        'userinfo_partnerid' => $this->USER_INFO['userinfo_partnerid'],
                    ],
                    //设置排序规则
                    $param_order = [],
                    $param_page = input('Page', 1),
                    $param_pagesize = input('PageSize', 10)
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
                //设置数据表名称
                    $param_table_name = self::TABLE_NAME,
                    //设置字段名称
                    $param_field = [
                        'id' => 'Id',
                        'userinfo_roleid' => 'RoleId',
                        'userinfo_name' => 'Name',
                        'userinfo_nickname' => 'Nickname',
                        'userinfo_account' => 'Account',
                        'userinfo_sex' => 'Sex',
                        'userinfo_email' => 'Email',
                        'userinfo_phone' => 'Phone',
                        'userinfo_header' => 'Header',
                        'userinfo_showorder' => 'Showorder',
                        'userinfo_password' => 'Password'
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
        $request_data = [
            $post_itemid = new RequestEntity('ItemId', 'ID', true, 0),
            $post_itemname = new RequestEntity('Name', '姓名', true, 20),
            $post_itemsex = new RequestEntity('Sex', '性别', true, 20),
            $post_itemphone = new RequestEntity('Phone', '电话', true, 20),
            $post_itemroleid = new RequestEntity('RoleId', '角色', true, 20),
            $post_itemimage = new RequestEntity('Image', '头像', false, 0),
        ];
        //表单内容验证
        $this->Validates($request_data);
        return
            parent::ResponseJson(
                parent::ModifyData(
                //设置数据表名称
                    $param_table_name = self::TABLE_NAME,
                    //设置查询条件
                    $param_field = [
                        'userinfo_name' => $post_itemname->text,
                        'userinfo_sex' => $post_itemsex->text,
                        'userinfo_phone' => $post_itemphone->text,
                        'userinfo_roleid' => $post_itemroleid->text,
                        'userinfo_header' => $post_itemimage->text
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
        $request_data = [
            $post_name = new RequestEntity('Name', '姓名', true, 0),
            $post_account = new RequestEntity('Account', '账户', true, 0),
            $post_Password = new RequestEntity('Password', '密码', true, 0),
            $post_sex = new RequestEntity('Sex', '性别', true, 0),
            $post_phone = new RequestEntity('Phone', '手机', true, 0),
            $post_roleid = new RequestEntity('RoleId', '角色', true, 0),
            $post_email = new RequestEntity('Email', '邮箱', true, 0),
            $post_itemimage = new RequestEntity('Image', '头像', false, 0),
        ];

        //表单内容验证
        $this->Validates($request_data);
        return
            parent::ResponseJson(
                parent::AddData(
                //设置数据表名称
                    $param_table_name = self::TABLE_NAME,
                    $param_field = [
                        'userinfo_partnerid' => $this->USER_INFO['userinfo_partnerid'],
                        'userinfo_name' => $post_name->text,
                        'userinfo_account' => $post_account->text,
                        'userinfo_password' => $post_Password->text,
                        'userinfo_sex' => $post_sex->text,
                        'userinfo_phone' => $post_phone->text,
                        'userinfo_roleid' => $post_roleid->text,
                        'userinfo_email' => $post_email->text,
                        'userinfo_header' => $post_itemimage->text
                    ]
                )
            );
    }

    /**
     * 修改密码
     * @return string
     */
    public function ChangePassword(){
        $request_data = [
            $post_itemid = new RequestEntity('UserId', 'ID', true, 0),
            $post_passwordold = new RequestEntity('password_old', '旧密码', true, 0),
            $post_passwordnew = new RequestEntity('password_new', '新密码', true, 0),
            $post_passwordconfirm = new RequestEntity('password_confirm', '确认密码', true, 0),
        ];
        $data = parent::GetDataInfoWithTag(
        //设置数据表名称
            $param_table_name = self::TABLE_NAME,
            //设置字段名称
            $param_field = [
                'id' => 'Id',
                'userinfo_password' => 'Password'
            ],
            //设置查询条件
            $param_where = [
                'id' => $post_itemid->text
            ]
        );
        $this->Validates($request_data);
//        if(md5($post_passwordold)!==$data['Password']){
//            return parent::ResponseJson(null,'原始密码不正确');
//        }else{
            if($post_passwordnew === $post_passwordconfirm){
//                parent::ModifyData(
//                //设置数据表名称
//                    $param_table_name = self::TABLE_NAME,
//                    //设置查询条件
//                    $param_field = [
//                        'userinfo_password' => $post_passwordnew->text
//                    ],
//                    //设置查询条件
//                    $param_where = [
//                        'id' => $post_itemid->text
//                    ]
//                );
            }else{
                return parent::ResponseJson(null,'两次密码不匹配');
            }
//        }

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
