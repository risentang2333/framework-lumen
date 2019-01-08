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
     * @return void
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
        $id = trim($request->input('id',''));
        if ($id == '') {
            die("缺少id");
        }
        $manager = $permissionService->getManagerById($id);
        if ($manager->is_administrator == 1) {
            die("超级管理员不可修改");
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
        // 管理员id
        $id = trim($request->input('id', ''));
        if ($id == '') {
            die("缺少id");
        }
        $roleIds = $request->input('roleIds','');
        if ($roleIds == '') {
            die("缺少角色组");
        }
        // 判断是否为超级管理员
        $manager = $permissionService->getManagerById($id);
        if ($manager->is_administrator == 1) {
            die("超级管理员不可修改");
        }
        $permissionService->editManagerRole($id, $roleIds);

        return send_data_json(0,"编辑成功");

    }

    public function getManager(Request $request)
    {
        $permissionService = new PermissionService;
        $id = trim($request->input('id', ''));
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
        $id = trim($request->input('id', ''));
        // 管理员姓名
        $name = trim($request->input('name', ''));
        // 账号
        $account = trim($request->input('account', ''));
        // 新密码
        $password = trim($request->input('password', ''));
        // 二次输入密码
        $repassword = trim($request->input('repassword', ''));
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
        $permissionService->saveManager($id, $name, $account, $password);

        return send_data_json(0,"编辑成功");
    }

    /**
     * 物理删除管理员
     *
     * @param Request $request
     * @return string
     */
    public function deleteManager(Request $request)
    {
        $permissionService = new PermissionService;

        $id = trim($request->input('id', ''));
        if ($id == '') {
            die("缺少id");
        }

        $manager = $permissionService->getManagerById($id);
        
        $permissionService->deleteManager($id);

        return send_data_json(0,"删除成功");
    }

    /**
     * 获取角色列表
     *
     * @return string
     */
    public function getRoleList()
    {
        $permissionService = new PermissionService;

        $list = $permissionService->getRoleList(true, 20);

        return $list;
    }

    /**
     * 获取角色
     *
     * @param Request $request
     * @return string
     */
    public function getRole(Request $request)
    {
        $permissionService = new PermissionService;
        // 角色id
        $id = trim($request->input('id', ''));
        if ($id == '') {
            die("缺少id");
        }
        // 超级管理员角色不能修改
        $role = $permissionService->getRoleByRoleId($id);
        if ($role->is_administrator == 1) {
            die("超级管理员不能修改");
        }
        return send_data_json(0, "获取成功", $role);
    }


    /**
     * 编辑角色信息
     *
     * @param Request $request
     * @return string
     */
    public function editRole(Request $request)
    {
        $permissionService = new PermissionService;
        // 角色id
        $id = trim($request->input('id', ''));
        // 角色名
        $name = trim($request->input('name', ''));
        if ($id == '') {
            die("缺少id");
        }
        if ($name == '') {
            die("缺少name");
        }
        // 超级管理员角色不能修改
        $role = $permissionService->getRoleByRoleId($id);
        if ($role->is_administrator == 1) {
            die("超级管理员不能修改");
        }

        $role = $permissionService->saveRole($id, $name);

        return send_data_json(0, "编辑成功");
    }

    /**
     * 物理删除角色
     *
     * @param Request $request
     * @return string
     */
    public function deleteRole(Request $request)
    {
        $id = trim($request->input('id', ''));
        if ($id == '') {
            die("缺少id");
        } 
        $role = $permissionService->getRoleByRoleId($id);

        $permissionService->deleteRole($id);

        return send_data_json(0, "删除角色成功");
    }

    /**
     * 获取角色权限信息
     *
     * @param Request $request
     * @return string
     */
    public function getRolePermission(Request $request)
    {
        $permissionService = new PermissionService;

        $id = trim($request->input('id', ''));
        if ($id == '') {
            die("缺少id");
        }
        // 超级管理员角色不能修改
        $role = $permissionService->getRoleByRoleId($id);
        if ($role->is_administrator == 1) {
            die("超级管理员不能修改");
        }
        // 所有权限信息
        $permissionList = $permissionService->getPermissionList(false);
        // 与角色绑定的权限id
        $rolePermissionIds = $permissionService->getRolePermissionByRoleId($id);
        
        $data = array(
            "rolePermissionIds" => $rolePermissionIds,
            "permissionList" => $permissionList
        );
        return send_data_json(0, "获取成功", $data);
    }

    /**
     * 编辑角色权限信息
     *
     * @param Request $request
     * @return string
     */
    public function editRolePermission(Request $request)
    {
        $permissionService = new PermissionService;

        $id = trim($request->input('id', ''));
        if ($id == '') {
            die("缺少id");
        }
        // 超级管理员角色不能修改
        $role = $permissionService->getRoleByRoleId($id);
        if ($role->is_administrator == 1) {
            die("超级管理员不能修改");
        }
        // 权限数组
        $permissions = trim($request->input('permissions',''));

        $permissionService->editRolePermission($id, $permissions);

        return send_data_json(0,"编辑成功");
    }

    /**
     * 获取权限列表
     *
     * @return void
     */
    public function getPermissionList()
    {
        $permissionService = new PermissionService;
        
        $list = $permissionService->getPermissionList(true, 20);

        return send_data_json(0, "获取成功", $list);
    }

    /**
     * 新添加权限所需信息
     *
     * @param Request $request
     * @return string
     */
    public function addPermission(Request $request)
    {
        $permissionService = new PermissionService;
        // 获取所有权限信息
        $permissions = $permissionService->getPermissionForTree();
        // 生成树结构
        $tree = $permissionService->getTree($permissions);
        // 生成下拉菜单数据
        $selection = $permissionService->visitTree($tree);
        
        $data = array(
            "selection" => $selection
        );
        return send_data_json(0, "获取成功", $data);
    }

    /**
     * 获取权限数据
     *
     * @param Request $request
     * @return string
     */
    public function getPermission(Request $request)
    {
        $permissionService = new PermissionService;
        
        $id = trim($request->input('id', ''));
        if ($id == '') {
            die("缺少id");
        }
        // 获取当前权限信息
        $permission = $permissionService->getPermissionById($id);
        // 获取所有权限信息
        $permissions = $permissionService->getPermissionForTree();
        // 生成树结构
        $tree = $permissionService->getTree($permissions);
        // 生成下拉菜单数据
        $selection = $permissionService->visitTree($tree);
        
        $data = array(
            "permission" => $permission,
            "selection" => $selection
        );
        return send_data_json(0, "获取成功", $data);
    }

    public function editPermission(Request $request)
    {
        $permissionService = new PermissionService;
        // 权限id,必传
        $params['id'] = trim($request->input('id', ''));
        // 权限路由，必传
        $params['route'] = trim($request->input('route', ''));
        // 权限名称，必传
        $params['name'] = trim($request->input('name', ''));
        // 权限描述，必传
        $params['description'] = trim($request->input('description', ''));
        // 权限图标
        $params['icon'] = trim($request->input('icon', ''));
        // 排序顺序
        $params['sort_order'] = trim($request->input('sort_order', 0));
        // 父级id，通过下拉框选择
        $params['parent_id'] = trim($request->input('parent_id', ''));
        // 是否侧拉展示
        $params['is_display'] = trim($request->input('is_display', ''));
        if ($params['id'] == '') {
            die("缺少id");
        }
        if ($params['route'] == '') {
            die("缺少route");
        }
        if ($params['name'] == '') {
            die("缺少name");
        }
        if ($params['description'] == '') {
            die("缺少description");
        }
        if ($params['parent_id'] == '') {
            die("缺少parent_id");
        }
        if ($params['is_display'] == '') {
            die("缺少is_display");
        }
        $permissionService->editPermission($params);

        return send_data_json(0, "编辑成功");
    }

    /**
     * 获取侧拉菜单数据
     *
     * @param Request $request
     * @return void
     */
    public function getMenu(Request $request)
    {
        $permissionService = new PermissionService;
        // 获取token
        $accessToken = trim($request->input('access_token', ''));
        // 通过token查询管理员
        $manager = $permissionService->getManagerByAccessToken($accessToken);
        // 获取管理员id
        $id = $manager->id;
        // 根据用户id查询角色id组
        $permissions = $permissionService->getPermissionByManagerId($id);

        $tree = $permissionService->getTree($permissions);

        return send_data_json(0, "success", $tree);
    }
}
