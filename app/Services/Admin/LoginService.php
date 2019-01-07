<?php

namespace App\Services\Admin;

use App\Entities\Managers;
use Illuminate\Support\Facades\DB;

class LoginService 
{
    public function login($account, $password)
    {
        // 过期时间
        $expire = time() + 86400 * 3;
        // accessToken
        $accessToken = md5(time().$account);

        $refreshToken = md5(time().'refresh'.$account);
        // 加密后的密码
        $encryptPwd = md5('manager'.$password);

        $manager = Managers::select(['id','account','name','access_token','refresh_token'])->where(['account'=>$account, 'password'=>$encryptPwd])->first();
        if (empty($manager)) {
            die('帐户名密码错误');
        }

        $manager->expire = $expire;
        $manager->access_token = $accessToken;
        $manager->refresh_token = $refreshToken;
        $manager->save();

        return $manager;
    }

    public function changeToken($refreshToken)
    {
        $manager = Managers::select(['id','account','name','access_token','refresh_token'])->where('refresh_token', $refreshToken)->first();
        if (empty($manager)) {
            die('没有该token');
        }
        // 新的过期时间
        $new_expire = time() + 86400 * 3;
        // 新的accessToken
        $new_accessToken = md5($manager->refresh_token);
        // 新的刷新token
        $new_refreshToken = md5(time().'refresh'.$manager->refresh_token);

        $manager->expire = $new_expire;
        $manager->access_token = $new_accessToken;
        $manager->refresh_token = $new_refreshToken;
        $manager->save();
        
        return $manager;
    }
}
