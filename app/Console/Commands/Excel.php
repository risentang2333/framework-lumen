<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Mail;

class BackupDatabase extends Command
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

    protected $signature = 'excel';

    protected $description = 'excel';

    public function handle()
    {
        $url = storage_path('1.xls');

        Excel::load($url, function ($reader){
            foreach ($reader->all()[0] as $key => $value) {
                if ($key >= 5) {
                    // 登记时间
                    $params['register_at'] = strtotime($value[1]);
                    // 认证状态
                    if (empty($value[2])) {
                        $params['authentication'] = 0;
                    } else {
                        $params['authentication'] = array_key_exists($value[2],auth) ? auth[$value[2]] :　0;
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
                        $params['working_status'] = array_key_exists($value[7], config_working_status) ? config_working_status[$value[7]] : 0;
                    }
                    print($params);
                }
            }
        });
    }
}