<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\User\UserService;

class UserController extends Controller
{
    /**
     * 会员注册
     *
     * @param Request $request
     * @return string
     */
    public function register(Request $request)
    {
        $userService = new UserService;
        // 昵称
        $name = $request->input('name','');
        // 电话号
        $phone = $request->input('phone','');
        // 密码
        $password = $request->input('password','');
        // 二次输入密码
        $rePassword = $request->input('rePassword','');
        // 验证码，暂时没有
        $captcha = $request->input('captcha','');
        if ($name == '') {
            send_data_json(10000,"请输入姓名");
        }
        if ($phone == '') {
            send_data_json(10001,"请输入手机号");
        }
        if ($password == '') {
            send_data_json(10002,"请输入密码");
        }
        if ($rePassword == '') {
            send_data_json(10003,"请再次确认密码");
        }
        if ($password != $rePassword) {
            send_data_json(10004,"确认密码错误");
            return '确认密码错误';
        }
        if ($userService->hasRegisterByPhone($phone)) {
            send_data_json(10005,"该电话已经被注册");
        }

        $userService->register($name, $phone, $password);

        send_data_json(0,"注册成功");
    }

    /**
     * 登陆
     *
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {
        $userService = new UserService;
        // 电话号
        $phone = $request->input('phone','');
        // 密码
        $password = $request->input('password','');
        if ($phone == '') {
            send_data_json(10001,"请输入手机号");
        }
        if ($password == '') {
            send_data_json(10002,"请输入密码");
        }
        if (!$userService->hasRegisterByPhone($phone)) {
            send_data_json(10006,"该电话号未注册");
        }
        $token = $userService->login($phone, $password);
        
        send_data_json(0,"登录成功",["token" => $token]);
    }

    public function checkToken(Request $request)
    {
        $userService = new UserService;
        $token = $request->input('token','');
        
        return $userService->checkToken($token);
    }
}
