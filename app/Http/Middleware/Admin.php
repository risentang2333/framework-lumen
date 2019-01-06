<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $accessToken = $request->input('accessToken','');
        if ($accessToken == '') {
            die('请传入accessToken');
        }
        $manager = DB::table('managers')->select(['id','name','account','access_token'])->where('access_token', $accessToken)->first();
        if (empty($manager)) {
            die('token不存在');
        }
        // if (time() > $manager->expire) {
        //     die('token已过期');
        // }
        $route = $request->path();
        // print_r($route);
        $permissions = $this->getPermissionByManagerId($manager->id);
        // print_r($permissions);exit;
        if (!in_array($route, $permissions)) {
            die("没有".$route."权限");
        }
        
        return $next($request);
    }

    private function getPermissionByManagerId($id)
    {
        $data = DB::select("SELECT `route` FROM `permissions` WHERE `is_display` = 1 and `id` IN (SELECT `permission_id` FROM `permission_role` WHERE `role_id` IN (SELECT `role_id` FROM `role_manager` WHERE `manager_id` = 1)) ORDER BY sort_order ASC");
        
        $permissions = array_column($data, 'route');

        return $permissions;
    }
}
