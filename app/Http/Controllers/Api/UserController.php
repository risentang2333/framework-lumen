<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Api\UserService;

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
            return '请输入姓名';
        }
        if ($phone == '') {
            return '请输入手机号';
        }
        if ($password == '') {
            return '请输入密码';
        }
        if ($rePassword == '') {
            return '请再次确认密码';
        }
        if ($password != $rePassword) {
            return '确认密码错误';
        }
        if ($userService->hasRegisterByPhone($phone)) {
            return '该电话已经被注册';
        }
        if ($userService->register($name, $phone, $password)) {
            return '注册成功';
        } else {
            return '注册失败';
        }
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
            return '请输入手机号';
        }
        if ($password == '') {
            return '请输入密码';
        }
        if (!$userService->hasRegisterByPhone($phone)) {
            return '该电话号未注册';
        }
        $token = $userService->login($phone, $password);
        
        return $token;
    }

    public function checkToken(Request $request)
    {
        $userService = new UserService;
        $token = $request->input('token','');
        
        return $userService->checkToken($token);
    }
}
