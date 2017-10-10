<?php

namespace app\wechat\controller;

use app\common\controller\BaseController;
use app\common\entity\RequestEntity;
use app\common\extend\Tools;
use app\common\extend\WeChat;

class WeChatOrder extends BaseController
{
    const TABLE_NAME = 'wechat_pay_order_info';

    public function ListItem()
    {
        return
            parent::ResponseJson(
                parent::GetDataListWithTag(
                //设置表名
                    $param_table_name = 'wechat_pay_order_info',
                    //设置查询字段
                    $param_field = [
                        'id' => 'Id',
                        'orderinfo_codeid' => 'CodeId',
                        'orderinfo_member_name' => 'MemberName',
                        'orderinfo_totalprices' => 'TotalPrices',
                        'orderinfo_ispay' => 'IsPay',
                        'orderinfo_member_phone' => 'MemberPhone',
                        'orderinfo_member_idcard' => 'MemberIdCard',
                        'orderinfo_createtime' => 'CreateTime'
                    ],
                    //设置查询条件
                    $param_where = [],
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
//    public function ItemInfo()
//    {
//        //获取请求参数
//        $request_data = [
//            $post_itemid = new RequestEntity('ItemId', 'ID', true, 0)
//        ];
//        //表单内容验证
//        parent::Validates($request_data);
//        $ItemId = $post_itemid->text;
//
//
//        return
//            parent::ResponseJson(
//                parent::GetDataInfoWithTag(
//                //设置表名
//                    $param_table_name = self::TABLE_NAME,
//                    //设置查询字段
//                    $param_field = [
//                        'partnerinfo_wechat_appid' => 'AppId',
//                        'partnerinfo_wechat_appsecret' => 'AppSecret',
//                        'partnerinfo_wechat_token' => 'Token',
//                        'partnerinfo_wechat_aeskey' => 'AESKey'
//                    ],
//                    //设置查询条件
//                    $param_where = [
//                        'id' => $ItemId,
//                    ]
//                )
//            );
//
//    }

    /**
     * 修改数据
     * @return string
     */
//    public function ModifyItem()
//    {
//        //获取请求参数
//        $request_data = [
//            $post_itemid = new RequestEntity('ItemId', 'ID', true, 0),
//            $post_appid = new RequestEntity('AppId', 'AppId', true, 50),
//            $post_appsecret = new RequestEntity('AppSecret', 'AppSecret', true, 50),
//            $post_token = new RequestEntity('Token', 'Token', true, 50),
//            $post_aeskey = new RequestEntity('AESKey', 'EncodingAESKey', true, 50),
//        ];
//        //验证表单内容
//        parent::Validates($request_data);
//        return
//            parent::ResponseJson(
//                parent::ModifyData(
//                //设置表名
//                    $param_table_name = self::TABLE_NAME,
//                    //设置修改字段
//                    $param_field = [
//                        'partnerinfo_wechat_appid' => $post_appid->text,
//                        'partnerinfo_wechat_appsecret' => $post_appsecret->text,
//                        'partnerinfo_wechat_token' => $post_token->text,
//                        'partnerinfo_wechat_aeskey' => $post_aeskey->text
//                    ],
//                    //设置查询条件
//                    $param_where = [
//                        'id' => $post_itemid->text,
//                    ]
//                )
//            );
//    }
    /**
     *
     * 导出Excel
     */
    public function ExportOrder(){
        $phpexcel = new \PHPExcel();
        $sql = parent::GetDataList(
            //设置表名
                $param_table_name = 'wechat_pay_order_info',
                //设置查询字段
                $param_field = [
                    'id' => 'Id',
                    'orderinfo_codeid' => 'CodeId',
                    'orderinfo_member_name' => 'MemberName',
                    'orderinfo_totalprices' => 'TotalPrices',
                    'orderinfo_ispay' => 'IsPay',
                    'orderinfo_member_phone' => 'MemberPhone',
                    'orderinfo_member_idcard' => 'MemberIdCard',
                    'orderinfo_createtime' => 'CreateTime'
                ],
                //设置查询条件
                $param_where = [
                ],
                //设置排序规则
                $param_order = [],
                $param_page = input('Page', 1),
                $param_pagesize = input('PageSize', 10)
            );

        // 设置文件属性
        $phpexcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        // 给表格添加数据
        $phpexcel->setActiveSheetIndex(0)             //设置第一个内置表（一个xls文件里可以有多个表）为活动的
                 ->setCellValue( 'A1', 'ID')         //给表的单元格设置数据
                 ->setCellValue( 'B1', '用户名')      //数据格式可以为字符串
                 ->setCellValue( 'C1', '消费总额')            //数字型
                 ->setCellValue( 'D1', '消费状态')            //
                 ->setCellValue( 'E1', '用户电话')           //布尔型
                 ->setCellValue( 'F1', '身份证')
                 ->setCellValue( 'G1', '创建时间');//公式
                    //得到当前活动的表,注意下文教程中会经常用到$objActSheet

        $count = count($sql);
        for($i=2;$i<=$count+1;$i++){
            $phpexcel->getActiveSheet()->setCellValue('A' . $i, $sql[$i-2]['CodeId']);
            $phpexcel->getActiveSheet()->setCellValue('B' . $i, $sql[$i-2]['MemberName']);
            $phpexcel->getActiveSheet()->setCellValue('C' . $i, $sql[$i-2]['TotalPrices']);
            $phpexcel->getActiveSheet()->setCellValue('D' . $i, $sql[$i-2]['IsPay']);
            $phpexcel->getActiveSheet()->setCellValue('E' . $i, $sql[$i-2]['MemberPhone']);
            $phpexcel->getActiveSheet()->setCellValue('F' . $i, $sql[$i-2]['MemberIdCard']);
            $phpexcel->getActiveSheet()->setCellValue('G' . $i, $sql[$i-2]['CreateTime']);
        }

        //重命名工作表
        $phpexcel->getActiveSheet()->setTitle('123');
        $phpexcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (OpenDocument)
        header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
        header('Content-Disposition: attachment;filename="01simple.ods"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * 搜索数据列表
     */
    public function SearchFormData ()
    {
        echo '222';
        exit;
        $request_data = [
            $post_search_data = new RequestEntity('Keyword', '检索内容', true, 0)
        ];


        //表单内容验证
        $this->Validates($request_data);
        $where = "orderinfo_member_idcard like '%" . $post_search_data->text . "%' or orderinfo_createtime like '%" . $post_search_data->text . "%'";
        return
            parent::ResponseJson(
                parent::GetDataListWithTag(
                //设置表名
                    $param_table_name = self::TABLE_NAME,
                    //设置查询字段
                    $param_field = [
                        'id' => 'Id',
                        'orderinfo_codeid' => 'CodeId',
                        'orderinfo_member_name' => 'MemberName',
                        'orderinfo_totalprices' => 'TotalPrices',
                        'orderinfo_ispay' => 'IsPay',
                        'orderinfo_member_phone' => 'MemberPhone',
                        'orderinfo_member_idcard' => 'MemberIdCard',
                        'orderinfo_createtime' => 'CreateTime'
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