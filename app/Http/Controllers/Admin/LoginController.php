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
        $account = $request->input('account','');
        // 密码
        $password = $request->input('password','');
        if ($account == '') {
            send_data_json(10001,"请输入账号");
        }
        if ($password == '') {
            send_data_json(10002,"请输入密码");
        }
        $data = $loginService->login($account, $password);
        
        send_data_json(0,"登录成功",$data);
    }

    public function changeToken(Request $request)
    {
        $loginService = new LoginService;
        // 接收accessToken
        $refreshToken = $request->input('refreshToken','');
        // 检查token是否传入
        if ($refreshToken == '') {
            die('请传入refreshToken');
        }
        $data = $loginService->changeToken($refreshToken);

        send_data_json(0,"+1s成功",$data);
    }
}
