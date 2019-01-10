<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\LoginService;

class LoginController extends Controller
{
    /**
     * 
     * 管理员登录
     *
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {
        $loginService = new LoginService;
        // 电话号
        $account = trim($request->input('account',''));
        // 密码
        $password = trim($request->input('password',''));
        if ($account == '') {
            send_msg_json(MISS_PARAMETER,"请输入账号");
        }
        if ($password == '') {
            send_msg_json(MISS_PARAMETER,"请输入密码");
        }
        $data = $loginService->login($account, $password);
        
        send_msg_json(0,"登录成功",$data);
    }

    /**
     * 更换accesstoken
     *
     * @param Request $request
     * @return string
     */
    public function changeToken(Request $request)
    {
        $loginService = new LoginService;
        // 接收accessToken
        $refreshToken = trim($request->input('refresh_token',''));
        // 检查token是否传入
        if ($refreshToken == '') {
            die('请传入refresh_token');
        }
        $data = $loginService->changeToken($refreshToken);

        send_msg_json(0,"+1s成功",$data);
    }
}
