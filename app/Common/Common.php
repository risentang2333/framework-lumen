<?php

if (!function_exists('send_post_request')) {
    /**
     * PHP发送Json对象数据, 发送HTTP请求
     *
     * @param string $url 请求地址
     * @param json $data 发送数据
     * @param boolen $https 是否为https
     * @return String
     */
    function send_post_request($url, $data, $https) {
        //初始化curl
        $ch = curl_init ();
        //设置请求url
        curl_setopt ( $ch, CURLOPT_URL, $url);
        //是否POST请求 
        curl_setopt ( $ch, CURLOPT_POST, true );
        //是否启用时将头文件的信息作为数据流输出 
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        //强制获取一个新的连接，而不是缓存中的连接 
        curl_setopt ( $ch, CURLOPT_FRESH_CONNECT, 1 );
        //将curl_exec()获取的信息以字符串返回，而不是直接输出 
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        if ($https == true) {
            // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // 从证书中检查SSL加密算法是否存在
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        //在完成交互以后强制明确的断开连接，不能在连接池中重用 
        curl_setopt ( $ch, CURLOPT_FORBID_REUSE, 1 ); 
        //设置过期时间
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 ); 
        //设置请求头信息
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, array ('Connection:Keep-Alive', 'Content-Type: application/json', 'Content-Length: ' . strlen ( $data ) ) );
        //设置POST请求参数
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data);
        //执行curl
        $ret = curl_exec ( $ch );
        // 使用该函数对结果进行转码
        $ret = mb_convert_encoding($ret, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
        //请求错误时打印错误信息
        if ($ret === false) {
            return 'Curl error: ' . curl_error($ch);
        }
        //关闭curl
        curl_close ( $ch );
        //返回结果
        return $ret;
    }
}

if (!function_exists('send_get_request')) {
    /**
     * PHP发送Json对象数据, 发送HTTP请求
     *
     * @param string $url 请求地址
     * @param array $data 发送数据
     * @return String
     */
    function send_get_request($url, $https) {
        
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        if ($https == true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        //执行并获取HTML文档内容
        $ret = curl_exec ( $ch );
        //释放curl句柄
        curl_close ( $ch );
        // 使用该函数对结果进行转码
        $ret = mb_convert_encoding($ret, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
        //请求错误时打印错误信息
        if ($ret === false) {
            return 'Curl error: ' . curl_error($ch);
        }
        //返回结果
        return $ret;
    }
}

if (!function_exists('send_msg_json')) {
    /**
     * PHP发送Json对象数据, 发送HTTP请求
     *
     * @param string $url 请求地址
     * @param array $data 发送数据
     * @return String
     */
    function send_msg_json($code, $message = "", $data = []) {
        die(json_encode([
            "code" => $code,
            "message" => $message,
            "data" => $data
        ], JSON_UNESCAPED_UNICODE));
    }
}

if (!function_exists('write_log')) {
    
    /**
     * 编写日志
     *
     * @param string $accessToken
     * @param string $message
     * @return boolean
     */
    function write_log($accessToken, $message) {
        // 操作者
        $manager = \Illuminate\Support\Facades\DB::table('managers')->select('id','name')->where('access_token', $accessToken)->first();
        // 操作者id
        $manager_id = $manager->id;
        // 操作者姓名
        $name = $manager->name;
        // 操作ip地址
        $ip = get_ip();
        // 创建时间
        $created_at = time();
        // 传递参数
        $params = [
            'manager_id' => $manager_id,
            'name' => $name,
            'ip' => $ip,
            'message' => $message,
            'created_at' => $created_at,
        ];
        // 写入
        \App\Common\Log::getInstance()->writeLog($params);

        return true;
    }
}

if (!function_exists('get_ip')) {
    /**
     * 获取执行ip地址
     *
     * @return void
     */
    function get_ip() {
        // 判断服务器是否允许$_SERVER
        if(isset($_SERVER)){    
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            }else{
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        }else{
            // 不允许就使用getenv获取  
            if(getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv( "HTTP_X_FORWARDED_FOR");
            }elseif(getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            }else{
                $realip = getenv("REMOTE_ADDR");
            }
        }

        return $realip;
    }
}

if (!function_exists('verify_phone')) {
    /**
     * 验证手机格式
     *
     * @param string $phone
     * @return string
     */
    function verify_phone($phone) {
        $pattern = '/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\d{8}$/';

        if (preg_match($pattern, $phone)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('verify_identity')) {
    /**
     * 验证身份证格式
     *
     * @param string $identity_card
     * @return string
     */
    function verify_identity($identity_card) {
        $pattern = '/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/';

        if (preg_match($pattern, $identity_card)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('verify_bank_card')) {
    /**
     * 验证银行卡格式
     *
     * @param string $number
     * @return string
     */
    function verify_bank_card($number) {
        $arr_number = str_split($number);
        $last_n = $arr_number[count($arr_number)-1];
        krsort($arr_number);
        $i = 1;
        $total = 0;
        foreach ($arr_number as $n) {
            if ($i%2 == 0) {
                $ix = $n * 2;
                if ($ix >= 10) {
                    $nx = 1 + ($ix % 10);
                    $total += $nx;
                } else {
                    $total += $ix;
                }
            } else {
                $total += $n;
            }
            $i++;
        }
        $total -= $last_n;
        $total *= 9;
        if ($last_n == ($total % 10)) {
            return true;
        } else {
            return false;
        }
    }
}
    