<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\PermissionService;

class PermissionController extends Controller
{
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

        $list = $permissionService->getRoleList();

        return $list;
    }

    public function getManagerList()
    {
        $permissionService = new PermissionService;

        $list = $permissionService->getManagerList();

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
