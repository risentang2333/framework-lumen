<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\PermissionService;

class PermissionController extends Controller
{
    /**
     * 获取管理员列表
     *
     * @return string
     */
    public function getManagerList()
    {
        $permissionService = new PermissionService;

        $list = $permissionService->getManagerList();

        return $list;
    }

    /**
     * 给managerId分配角色
     *
     * @param Request $request
     * @return void
     */
    public function getManagerRole(Request $request)
    {
        $permissionService = new PermissionService;
        // 管理员id
        $id = $request->input('id','');
        if ($id == '') {
            die("缺少id");
        }
        // 获取不带分页的所有角色信息
        $roleList = $permissionService->getRoleList(false);
        // 根据管理员id获取已经绑定的角色id
        $roleIds = $permissionService->getRoleIdsByManagerId($id);

        $data = array(
            'roleIds' => $roleIds,
            'roleList' => $roleList
        );

        return send_data_json(0,"获取成功",$data);
    }

    public function editManagerRole(Request $request)
    {
        $permissionService = new PermissionService;
        
        $id = $request->input('id', '');
        if ($id == '') {
            die("缺少id");
        }
        $roles = $request->input('roles','');
        dd($roles);
        if ($roles == '') {
            die("缺少角色组");
        }
        // $roles = [];
        // print_r($roles);exit;
        $permissionService->allotManagerRole($id, $roles);

        return send_data_json(0,"编辑成功");

    }

    public function getManager(Request $request)
    {
        $permissionService = new PermissionService;
        $id = $request->input('id', '');
        if ($id == '') {
            die("缺少id");
        }
        $manager = $permissionService->getManagerById($id);

        return send_data_json(0,"获取成功",$manager);
    }

    public function editManager(Request $request)
    {
        $permissionService = new PermissionService;
        // 管理员id
        $id = $request->input('id', '');
        // 管理员姓名
        $name = $request->input('name', '');
        // 新密码
        $password = $request->input('password', '');
        // 二次输入密码
        $repassword = $request->input('repassword', '');
        if ($id == '') {
            die("缺少id");
        }
        if ($name == '') {
            die("缺少姓名");
        }
        if ($password == '' && $repassword != '') {
            die("缺少新密码");
        }
        if ($repassword == '' && $password != '') {
            die("缺少二次密码");
        }
        if ($password != $repassword) {
            die("密码确认错误");
        }
        $permissionService->editManager($id, $name, $password);

        return send_data_json(0,"编辑成功");
    }

    public function getRoleList()
    {
        $permissionService = new PermissionService;

        $list = $permissionService->getRoleList(true, 20);

        return $list;
    }

    

    public function getMenu()
    {
        $permissionService = new PermissionService;

        $id = 1;
        // 根据用户id查询角色id组
        $roleIds = $permissionService->getRoleIdsByManagerId($id);

        $data = $permissionService->getPermissionByRoleIds($roleIds);
        // 生成树结构

        $tree = $permissionService->getTree($data);

        return $tree;
    }

    

    public function getPermissionList()
    {
        $permissionService = new PermissionService;
        
        $list = $permissionService->getPermissionList();

        return $list;

    }

    public function allotPermission(Request $request)
    {
        $json = $request->post('json');
    }

    public function editPermission(Request $request)
    {
        $id = 1;

        $permissionService = new PermissionService;
        
        if ($id != 0) {
            $permission = $permissionService->getPermissionById($id);
        }

        $permissions = $permissionService->getPermissions();

        $tree = $permissionService->getTree($data);

        $selection = $permissionService->visitTree($tree);
        
        return $selection;
    }
}
