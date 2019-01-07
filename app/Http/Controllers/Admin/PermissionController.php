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
    public function editManagerRole(Request $request)
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

    public function allotManagerRole(Request $request)
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

    public function getRoleList()
    {
        $permissionService = new PermissionService;

        $list = $permissionService->getRoleList($paginate);

        return $list;
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
