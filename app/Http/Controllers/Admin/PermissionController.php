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
            send_msg_json(ERROR_RETURN, "请传入管理员id");
        }
        $manager = $permissionService->getManagerById($id);
        if (empty($manager)) {
            send_msg_json(ERROR_RETURN, '管理员不存在');
        }
        if ($manager->is_administrator == 1) {
            send_msg_json(ERROR_RETURN, "超级管理员不可修改");
        }
        // 获取不带分页的所有角色信息
        $roleList = $permissionService->getRoleList(false);
        // 根据管理员id获取已经绑定的角色id
        $roleIds = $permissionService->getRoleIdsByManagerId($id);

        $data = array(
            'roleIds' => $roleIds,
            'roleList' => $roleList
        );

        return send_msg_json(SUCCESS_RETURN, "success", $data);
    }

    /**
     * 分配绑定管理员角色
     *
     * @param Request $request
     * @return string
     */
    public function editManagerRole(Request $request)
    {
        $permissionService = new PermissionService;
        // 管理员id
        $id = trim($request->input('id', ''));
        if ($id == '') {
            send_msg_json(ERROR_RETURN, "请传入管理员id");
        }
        // 角色组
        $roleIds = $request->input('roleIds','');
        if ($roleIds == ''|| !is_array($roleIds)) {
            send_msg_json(ERROR_RETURN, "请传入角色组");
        }
        // 判断是否为超级管理员
        $manager = $permissionService->getManagerById($id);
        if (empty($manager)) {
            send_msg_json(ERROR_RETURN, '管理员不存在');
        }
        if ($manager->is_administrator == 1) {
            send_msg_json(ERROR_RETURN, "超级管理员不可修改");
        }
        $permissionService->editManagerRole($id, $roleIds);

        return send_msg_json(SUCCESS_RETURN, "编辑成功");

    }

    /**
     * 获取管理员信息
     *
     * @param Request $request
     * @return string
     */
    public function getManager(Request $request)
    {
        $permissionService = new PermissionService;
        $id = trim($request->input('id', ''));
        if ($id == '') {
            send_msg_json(ERROR_RETURN, "请传入管理员id");
        }
        $manager = $permissionService->getManagerById($id);
        if (empty($manager)) {
            send_msg_json(ERROR_RETURN, '管理员不存在');
        }
        return send_msg_json(SUCCESS_RETURN, "success", $manager);
    }

    /**
     * 编辑管理员信息
     *
     * @param Request $request
     * @return string
     */
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
            send_msg_json(ERROR_RETURN, "请传入姓名");
        }
        if ($password == '' && $repassword != '') {
            send_msg_json(ERROR_RETURN, "请传入新密码");
        }
        if ($repassword == '' && $password != '') {
            send_msg_json(ERROR_RETURN, "请再次确认密码");
        }
        if ($password != $repassword) {
            send_msg_json(ERROR_RETURN, "密码验证错误，请重新输入");
        }
        $permissionService->saveManager($id, $name, $account, $password);

        return send_msg_json(SUCCESS_RETURN, "编辑成功");
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
            send_msg_json(ERROR_RETURN, "请传入管理员id");
        }
        $manager = $permissionService->getManagerById($id);
        if (empty($manager)) {
            send_msg_json(ERROR_RETURN, '该管理员不存在');
        }
        if ($role->is_administrator == 1) {
            send_msg_json(ERROR_RETURN, "超级管理员不能删除");
        }
        
        $permissionService->deleteManager($id);

        return send_msg_json(SUCCESS_RETURN, "删除成功");
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

        return send_msg_json(SUCCESS_RETURN, "success", $list);
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
            send_msg_json(ERROR_RETURN, "请传入角色id");
        }
        // 超级管理员角色不能修改
        $role = $permissionService->getRoleByRoleId($id);
        if (empty($role)) {
            send_msg_json(ERROR_RETURN, '该角色不存在');
        }
        if ($role->is_administrator == 1) {
            send_msg_json(ERROR_RETURN, "超级管理员不能修改");
        }
        return send_msg_json(SUCCESS_RETURN, "获取成功", $role);
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
            send_msg_json(ERROR_RETURN, "请传入角色id");
        }
        if ($name == '') {
            send_msg_json(ERROR_RETURN, "请传入角色名");
        }
        // 超级管理员角色不能修改
        $role = $permissionService->getRoleByRoleId($id);
        if (empty($role)) {
            send_msg_json(ERROR_RETURN, "该角色不存在");
        }
        if ($role->is_administrator == 1) {
            send_msg_json(ERROR_RETURN, "超级管理员不能修改");
        }

        $role = $permissionService->saveRole($id, $name);

        return send_msg_json(SUCCESS_RETURN, "编辑成功");
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
            send_msg_json(ERROR_RETURN, "请传入角色id");
        } 
        $role = $permissionService->getRoleByRoleId($id);
        if ($role->is_administrator == 1) {
            send_msg_json(ERROR_RETURN, "超级管理员不能修改");
        }

        $permissionService->deleteRole($id);

        return send_msg_json(SUCCESS_RETURN, "删除成功");
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
        // 角色id
        $id = trim($request->input('id', ''));
        if ($id == '') {
            send_msg_json(ERROR_RETURN, "请传入角色id");
        }
        // 超级管理员角色不能修改
        $role = $permissionService->getRoleByRoleId($id);
        if (empty($role)) {
            send_msg_json(ERROR_RETURN, "管理员不存在");
        }
        if ($role->is_administrator == 1) {
            send_msg_json(ERROR_RETURN, "超级管理员不能修改");
        }
        // 所有权限信息
        $permissionList = $permissionService->getPermissionList(false);
        // 与角色绑定的权限id
        $rolePermissionIds = $permissionService->getRolePermissionByRoleId($id);
        
        $data = array(
            "rolePermissionIds" => $rolePermissionIds,
            "permissionList" => $permissionList
        );
        return send_msg_json(SUCCESS_RETURN, "success", $data);
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
        // 角色id
        $id = trim($request->input('id', ''));
        if ($id == '') {
            send_msg_json(ERROR_RETURN, "请传入角色id");
        }
        // 权限数组
        $permissionIds = $request->input('permissionIds','');
        if ($permissionIds == ''|| !is_array($permissionIds)) {
            send_msg_json(ERROR_RETURN, "请传入绑定权限组");
        }
        // 超级管理员角色不能修改
        $role = $permissionService->getRoleByRoleId($id);
        if ($role->is_administrator == 1) {
            send_msg_json(ERROR_RETURN, "超级管理员不能修改");
        }
        
        $permissionService->editRolePermission($id, $permissionIds);

        return send_msg_json(SUCCESS_RETURN, "编辑成功");
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

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }

    /**
     * 获取权限数据
     *
     * @param Request $request
     * @return string
     */
    public function getPermission(Request $request)
    {
        $data = array();

        $permissionService = new PermissionService;
        
        $id = trim($request->input('id', ''));
        if ($id == '') {
            // 表单形式
            $data['method'] = "add";

            $data['permission'] = [];
        } else {
            // 获取当前权限信息
            $permission = $permissionService->getPermissionById($id)->toArray();
            
            if (empty($permission)) {
                send_msg_json(ERROR_RETURN, "权限信息不存在");
            }
            // 表单形式
            $data['method'] = "edit";
            // 通过id查到的权限
            $data['permission'] = $permission;
        }
        
        // 获取所有权限信息
        $permissions = $permissionService->getPermissionForTree();
        // 生成树结构
        $tree = $permissionService->getTree($permissions);
        // 生成下拉菜单数据
        $selection = $permissionService->visitTree($tree);
        
        $data['selection'] = $selection;

        return send_msg_json(SUCCESS_RETURN, "success", $data);
    }

    /**
     * 编辑权限信息
     *
     * @param Request $request
     * @return string
     */
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

        $params['is_api'] = trim($request->input('is_api', ''));
        if ($params['id'] == '') {
            send_msg_json(ERROR_RETURN, "请传入权限id");
        }
        if ($params['route'] == '') {
            send_msg_json(ERROR_RETURN, "请传入路由");
        }
        if ($params['name'] == '') {
            send_msg_json(ERROR_RETURN, "请传入权限名");
        }
        if ($params['description'] == '') {
            send_msg_json(ERROR_RETURN, "请传入权限描述");
        }
        if ($params['parent_id'] == '') {
            send_msg_json(ERROR_RETURN, "请传入父级id");
        }
        if ($params['is_display'] == '') {
            send_msg_json(ERROR_RETURN, "请传入是否展示");
        }
        if ($params['is_api'] == '') {
            send_msg_json(ERROR_RETURN, "请传入是否为接口");
        }
        $permissionService->editPermission($params);

        return send_msg_json(SUCCESS_RETURN, "编辑成功");
    }

    /**
     * 物理删除权限
     *
     * @param Request $request
     * @return string
     */
    public function deletePermission(Request $request)
    {
        $permissionService = new PermissionService;
        $id = trim($request->input('id', ''));
        if ($id == '') {
            send_msg_json(ERROR_RETURN, "请传入权限id");
        }

        $permission = $permissionService->getPermissionById($id);
        if (empty($permission)) {
            send_msg_json(ERROR_RETURN, "权限信息不存在");
        }
        if ($permission['is_administrator'] == 1) {
            send_msg_json(ERROR_RETURN, "超管权限无法删除");
        }
        $permissionService->deletePermission($id);

        return send_msg_json(SUCCESS_RETURN, "删除成功");
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
        if (empty($manager)) {
            send_msg_json(ERROR_RETURN, "管理员不存在");
        }
        // 获取管理员id
        $id = $manager->id;
        // 根据用户id查询角色id组
        $permissions = $permissionService->getPermissionByManagerId($id);

        $tree = $permissionService->getTree($permissions);

        return send_msg_json(0, "success", $tree);
    }
}
