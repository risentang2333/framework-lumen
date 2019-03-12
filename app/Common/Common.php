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

if (!function_exists('getTree')) {
    /**
     * 生成树结构
     *
     * @param array $items
     * @return array
     */
    function getTree($items, $forMenu = false)
    {
        $tree = array();
        foreach($items as $item){
            if(isset($items[$item['parent_id']])){
                if ($forMenu) {
                    // 当路由不显示的时候
                    if ($item['is_display'] == 2) {
                        $items[$item['parent_id']]['contains'][] = &$items[$item['id']];
                    } else {
                        $items[$item['parent_id']]['children'][] = &$items[$item['id']];
                    }
                } else {
                    $items[$item['parent_id']]['children'][] = &$items[$item['id']];
                }
            }else{
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }
}

if (!function_exists('filterTreeById')) {
    /**
     * 从基础树中根据节点id，筛选树
     *
     * @param array $items
     * @return array
     */
    function filterTreeById($tree, $id)
    {
        static $deleteTree = array();
        
        foreach ($tree as $value) {
            if ($value['id'] == $id) {
                $deleteTree = $value;
            } else if (isset($value['children'])) {
                filterTreeById($value['children'], $id);
            }
        }
        return $deleteTree;
    }
}

if (!function_exists('getFilterIds')) {
    /**
     * 根据筛选出的树，获取筛选id的集合
     *
     * @param array $items
     * @return array
     */
    function getFilterIds($tree)
    {
        static $deleteIds = array();

        array_push($deleteIds, $tree['id']);
        if (isset($tree['children'])) {
            foreach ($tree['children'] as $value) {
                getFilterIds($value);
            }
        }
        return $deleteIds;
    }
}

if (! function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param  string  $path
     * @return string
     */
    function public_path($path = '')
    {
        return app()->basePath() .DIRECTORY_SEPARATOR. 'public' . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : DIRECTORY_SEPARATOR);
    }
}

if (! function_exists('file_upload')) {
    /**
     * 文件上传处理
     *
     * @param uploadedFile $file
     * @param int $width
     * @param int $height
     * @return string string
     */
    function file_upload($file, int $width = 0, int $height = 0)
    {
        //验证上传文件是否有效
        if (!$file || !$file->isValid()) {
            send_msg_json(ERROR_RETURN, "上传的文件无效");
        }
        //获取文件后缀
        $ext = $file->getClientOriginalExtension();
        //临时绝对路径  
        $tmpPath = $file->getRealPath();
        //移动文件
        $path = move_upload_file($tmpPath, '' , $ext);
        //裁剪图片
        if ($width && $height) {
            $img = \Image::make(public_path() . '/resource' . '/' . $path)->resize($width, $height)
                ->save(public_path() . '/resource' . '/' . $path);
        }
        //返回上传文件路径
        return $path;
    }
}

if (! function_exists('move_upload_file')) {
    /**
     * 移动上传文件处理
     *
     * @param string $filePath
     * @param string $type
     * @param string $module
     * @return string string
     */
    function move_upload_file(string $filePath, string $module = '', string $type = '')
    {
        //判断文件是否存在
        if(!file_exists($filePath)) {
            //获取临时文件绝对路径
            $filePath = public_path() . '/resource' . '/'. $filePath;
            if (!file_exists($filePath)) {
                return $filePath;
            }
        }
        //判断业务目录
        switch ($module) {
            case 'Goods' :
                //商品图片文件生成目录
                $dir = env('GOODS_IMAGE_PATH', 'goods/');
                break;
            default:
                //默认临时目录
                $dir = 'temp/';
        }
        //处理生成目录
        if ($module) {
            //获取文件信息数组
            $pathInfo = pathinfo($filePath);
            //目录绝对路径
            $fullDirPath = public_path() . '/resource' . '/'. $dir;
            //初始目录不存在构建
            if(!is_dir($fullDirPath)) {
                $dir .= '1/';
            } else {
                //存在获取目录下目录数组
                $dirArray = scandir($fullDirPath);
                //最后一个目录名称
                $dirName = $dirArray[count($dirArray) - 1];
                //最后一个目录路径
                $dirPath = $fullDirPath . $dirName . '/';
                //获取最后一个目录下文件数
                $fileArray = scandir($dirPath);
                //如果文件数量大于配置数量创建新文件夹
                $dir .= count($fileArray) - 2 >= env('IMAGE_LIMIT', 100) ? ($dirName + 1) . '/' : $dirName . '/';
            }
            //移动到的文件绝对路径
            $path = $dir . $pathInfo['filename'] . '.' . $pathInfo['extension'];
        } else {
            //存储在临时目录
            $path = $dir .  md5(time() . uniqid()) . '.' . $type;
        }
        //目录绝对路径
        $fullPath = public_path() . '/resource' . '/' . $dir;
        //文件绝对路径
        $fullFilePath = public_path() . '/resource' . '/' . $path;
        //存储文件目录
        if (!is_dir($fullPath)) {
            @mkdir($fullPath, 0777, true);
        }
        //移动文件到resource temp
        Illuminate\Support\Facades\File::move($filePath, $fullFilePath);
        //赋予权限
        @chmod($fullFilePath, 0777);
        //非临时文件时图片缩放处理并删除文件
        if ($module) {
            if ($type == 'image') {
                image_shrink($fullFilePath);
            }
        }
        //返回移动文件路径
        return $path;
    }
}
    