<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\LogService;

use Maatwebsite\Excel\Facades\Excel;


class LogController extends Controller
{
    // 认证状态数组
    const auth = [
        "认证通过（已培训）"=>1,
        "未完成认证（未听课）"=>2
    ];

    const config_working_status = [
        "可接单"=>1,
        "暂不接单"=>2,
        "更改行业"=>3,
        "已上户（非365）"=>4,
        "已上户"=>5
    ];
    const config_skill = [
        "小时工"=>1,
        "保姆"=>2,
        "月嫂"=>3,
        "育儿嫂"=>4,
        "育婴师"=>5,
        "护工"=>6,
    ];
    const config_working_age = [
        "0-1年"=>1,
        "1-3年"=>2,
        "3-5年"=>3,
        "5-10年"=>4,
        "10年以上"=>5,
        "0"=>6,
        "0.5"=>7,
        "1"=>8,
        "1.5"=>9,
        "2"=>10,
        "2.5"=>11,
        "3"=>12,
        "4"=>13,
        "5"=>14,
        "6"=>15,
        "7"=>16,
        "8"=>17,
        "9"=>18,
        "10"=>19
    ];
    const config_service_crowd = [
        "打扫卫生"=>1,
        "只做饭"=>2,
        "做饭+打扫卫生"=>3,
        "照顾0-1岁宝宝"=>4,
        "照顾1-3岁宝宝"=>5,
        "接孩子"=>6,
        "自理老人"=>7,
        "半自理老人"=>8,
        "不自理老人"=>9,
    ];
    public function getLogList(Request $request)
    {
        $logService = new LogService;
        // 开始时间戳
        $startTime = trim($request->input('startTime',''));
        // 结束时间戳
        $endTime = trim($request->input('endTime',''));
        // 名字
        $params['name'] = trim($request->input('name',''));

        $pageNumber = (int)trim($request->input('pageNumber', 15));
        // 当不传时间时按当天计算
        if ($startTime == '' || $endTime == '') {
            // 该月第一天时间戳
            $startTime = strtotime(date("Y-m-01"));
            // 当天时间戳
            $endTime = time();
        }
        // 判断是否可以跨月份
        if (date("m", $startTime) != date("m", $endTime)) {
            send_msg_json(ERROR_RETURN, "查询日期不能跨月");
        }
        // 指定查询表
        $table = 'log_'.date('Ym',$startTime);
        
        $list = $logService->getLogList($startTime, $endTime, $table, $params, $pageNumber);
        // 开始时间
        $list['startTime'] = $startTime;
        // 结束时间
        $list['endTime'] = $endTime;

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }
    
    public function excel()
    {
        $url = storage_path('1.xls');

        Excel::load($url, function ($reader){
            foreach ($reader->all()[0] as $key => $value) {
                if ($key >= 2) {
                    // 登记时间
                    $params['register_at'] = strtotime($value[1]);
                    // 认证状态
                    if (empty($value[2])) {
                        $params['authentication'] = 0;
                    } else {
                        $params['authentication'] = array_key_exists($value[2],self::auth) ? self::auth[$value[2]] :　0;
                    }
                    // 姓名
                    $params['name'] = $value[3];
                    // 年龄
                    $params['age'] = $value[4];
                    // 电话
                    $params['phone'] = $value[5];
                    // 回访信息
                    $params['return_msg'] = $value[6];
                    // 接单状态
                    if (empty($value[7])) {
                        $params['working_status'] = 0;
                    } else {
                        $params['working_status'] = array_key_exists($value[7], self::config_working_status) ? self::config_working_status[$value[7]] : 0;
                    }
                    // 备注
                    $params['remarks'] = $value[8];
                    // 职业类型
                    $params['skill'] = [];
                    if (empty($value[9])) {
                        $params['skill'] = [];
                    } else {
                        $skill_array = explode("、",$value[9]);
                        foreach ($skill_array as $k => $v) {
                            if (array_key_exists($v, self::config_skill)) {
                                array_push($params['skill'], self::config_skill[$v]);
                            }
                        }
                    }
                    // 服务类型,找王硕对
                    $params['service_type'] = $value[10];
                    // 可服务人群
                    $params['label'] = [];
                    if (empty($value[11])) {
                        $params['label'] = [];
                    } else {
                        $label_array = explode("、",$value[11]);
                        
                        foreach ($label_array as $k => $v) {
                            if (array_key_exists($v, self::config_service_crowd)) {
                                array_push($params['label'], self::config_service_crowd[$v]);
                            }
                        }
                    }
                    // if ($value[5] == '13840141076') {
                    //     print_r($params['label']);exit;
                    // }
                    // 工龄
                    
                    print_r($params);
                }
            }
        });
    }
}
