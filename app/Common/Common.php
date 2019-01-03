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
    