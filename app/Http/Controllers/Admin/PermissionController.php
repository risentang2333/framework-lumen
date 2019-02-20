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
    public function getManagerList(Request $request)
    {
        $permissionService = new PermissionService;

        $params['name'] = trim($request->input('name',''));
        
        $list = $permissionService->getManagerList($params);

        return send_msg_json(SUCCESS_RETURN, "success", $list);
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
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入管理员id");
        }
        $manager = $permissionService->getManagerById($id);
        if (empty($manager)) {
            send_msg_json(ERROR_RETURN, '管理员不存在');
        }
        if ($manager->is_administrator == 2) {
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
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入管理员id");
        }
        // 角色组
        $roleIds = $request->input('roleIds', array());
        // 判断是否为超级管理员
        $manager = $permissionService->getManagerById($id);
        if (empty($manager)) {
            send_msg_json(ERROR_RETURN, '管理员不存在');
        }
        if ($manager->is_administrator == 2) {
            send_msg_json(ERROR_RETURN, "超级管理员不可修改");
        }
        $permissionService->saveManagerRole($id, $roleIds);

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
        // 管理员id
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入管理员id");
        }
        // 管理员对象
        $manager = $permissionService->getManagerById($id);
        if (empty($manager)) {
            send_msg_json(ERROR_RETURN, '管理员不存在');
        }
        if ($manager->is_administrator == 2) {
            send_msg_json(ERROR_RETURN, "超级管理员不可修改");
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
        $id = (int)trim($request->input('id', 0));
        // 管理员姓名
        $name = trim($request->input('name', ''));
        // 账号
        $account = trim($request->input('account', ''));
        // 新密码
        $password = trim($request->input('password', ''));
        // 二次输入密码
        $repassword = trim($request->input('repassword', ''));
        // 成功时回传信息
        $returnMsg = '添加成功';
        if (!empty($id)) {
            $manager = $permissionService->getManagerById($id);
            if (empty($manager)) {
                send_msg_json(ERROR_RETURN, '管理员不存在');
            }
            if ($manager->is_administrator == 2) {
                send_msg_json(ERROR_RETURN, "超级管理员不可修改");
            }
            $returnMsg = '编辑成功';
        }
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

        return send_msg_json(SUCCESS_RETURN, $returnMsg);
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

        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入管理员id");
        }
        $manager = $permissionService->getManagerById($id);
        if (empty($manager)) {
            send_msg_json(ERROR_RETURN, '该管理员不存在');
        }
        if ($role->is_administrator == 2) {
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

        $list = $permissionService->getRoleList(true, 15);

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
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入角色id");
        }
        // 超级管理员角色不能修改
        $role = $permissionService->getRoleByRoleId($id);
        if (empty($role)) {
            send_msg_json(ERROR_RETURN, '该角色不存在');
        }
        if ($role->is_administrator == 2) {
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
        $id = (int)trim($request->input('id', 0));
        // 角色名
        $name = trim($request->input('name', ''));
        // 成功时回传信息
        $returnMsg = '添加成功';
        if ($name == '') {
            send_msg_json(ERROR_RETURN, "请传入角色名");
        }
        if (!empty($id)) {
            $role = $permissionService->getRoleByRoleId($id);
            if (empty($role)) {
                send_msg_json(ERROR_RETURN, "该角色不存在");
            }
            // 超级管理员角色不能修改
            if ($role->is_administrator == 2) {
                send_msg_json(ERROR_RETURN, "超级管理员不能修改");
            }
            $returnMsg = '编辑成功';
        }
        $role = $permissionService->saveRole($id, $name);

        return send_msg_json(SUCCESS_RETURN, $returnMsg);
    }

    /**
     * 物理删除角色
     *
     * @param Request $request
     * @return string
     */
    public function deleteRole(Request $request)
    {
        $permissionService = new PermissionService;

        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入角色id");
        } 
        $role = $permissionService->getRoleByRoleId($id);
        if (empty($role)) {
            send_msg_json(ERROR_RETURN, "该角色不存在");
        }
        if ($role->is_administrator == 2) {
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
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入角色id");
        }
        // 超级管理员角色不能修改
        $role = $permissionService->getRoleByRoleId($id);
        if (empty($role)) {
            send_msg_json(ERROR_RETURN, "管理员不存在");
        }
        if ($role->is_administrator == 2) {
            send_msg_json(ERROR_RETURN, "超级管理员不能修改");
        }
        // 所有权限信息
        $permissions = $permissionService->getPermissionForTree(true);
        // 与角色绑定的权限id
        $rolePermissionIds = $permissionService->getRolePermissionByRoleId($id);
        // 添加是否为选中项
        foreach ($permissions as $key => $value) {
            if (in_array($value['id'], $rolePermissionIds)) {
                $permissions[$key]['is_on'] = true;
            } else {
                $permissions[$key]['is_on'] = false;
            }
        }
        // 生成树结构
        $permissionList = $permissionService->getTree($permissions);
        
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
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入角色id");
        }
        // 权限数组
        $permissionIds = $request->input('permissionIds', array());
        
        // 超级管理员角色不能修改
        $role = $permissionService->getRoleByRoleId($id);
        if (empty($role)) {
            send_msg_json(ERROR_RETURN, "该角色不存在");
        }
        if ($role->is_administrator == 2) {
            send_msg_json(ERROR_RETURN, "超级管理员不能修改");
        }
        
        $permissionService->saveRolePermission($id, $permissionIds);

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
        
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            // 表单形式
            $data['method'] = "add";

            $data['permission'] = array();
        } else {
            // 获取当前权限信息
            $permission = $permissionService->getPermissionById($id)->toArray();
            
            if (empty($permission)) {
                send_msg_json(ERROR_RETURN, "权限信息不存在");
            }

            if ($permission['is_administrator'] == 2) {
                send_msg_json(ERROR_RETURN, "基础权限无法修改");
            }
            // 表单形式
            $data['method'] = "edit";
            // 通过id查到的权限
            $data['permission'] = $permission;
        }
        
        // 获取所有权限信息
        $permissions = $permissionService->getPermissionForTree(false);
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
        $params['id'] = (int)trim($request->input('id', 0));
        // 权限路由，必传
        $params['router'] = trim($request->input('router', ''));
        // 权限名称，必传
        $params['title'] = trim($request->input('title', ''));
        // 权限描述，必传
        $params['description'] = trim($request->input('description', ''));
        // 权限图标
        // $params['icon'] = trim($request->input('icon', ''));
        // 排序顺序
        $params['sort_order'] = trim($request->input('sort_order', 0));
        // 父级id，通过下拉框选择
        $params['parent_id'] = trim($request->input('parent_id', ''));
        // 是否侧拉展示
        $params['is_display'] = (int)trim($request->input('is_display', 1));
        // 成功时回传信息
        $returnMsg = '添加成功';
        // 编辑权限时验证超管
        if (!empty($params['id'])) {
            // 权限信息
            $permission = $permissionService->getPermissionById($params['id']);
            if (empty($permission)) {
                send_msg_json(ERROR_RETURN, "该权限不存在");
            }
            if ($permission->is_administrator == 2) {
                send_msg_json(ERROR_RETURN, "基础权限无法修改");
            }
            $returnMsg = '编辑成功';
        }
        if ($params['router'] == '') {
            send_msg_json(ERROR_RETURN, "请传入路由");
        }
        if ($params['title'] == '') {
            send_msg_json(ERROR_RETURN, "请传入权限名");
        }
        if ($params['description'] == '') {
            send_msg_json(ERROR_RETURN, "请传入权限描述");
        }
        if ($params['parent_id'] == '') {
            send_msg_json(ERROR_RETURN, "请传入父级id");
        }
        if (empty($params['is_display'])) {
            send_msg_json(ERROR_RETURN, "请传入是否展示");
        }
        $permissionService->savePermission($params);

        return send_msg_json(SUCCESS_RETURN, $returnMsg);
    }

    /**
     * 逻辑删除权限
     *
     * @param Request $request
     * @return string
     */
    public function deletePermission(Request $request)
    {
        $permissionService = new PermissionService;
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入权限id");
        }
        $permission = $permissionService->getPermissionById($id);
        if (empty($permission)) {
            send_msg_json(ERROR_RETURN, "权限信息不存在");
        }
        if ($permission->is_administrator == 2) {
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
        $accessToken = trim($request->header('accessToken',''));
        // 通过token查询管理员
        $manager = $permissionService->getManagerByAccessToken($accessToken);
        if (empty($manager)) {
            send_msg_json(ERROR_RETURN, "管理员不存在");
        }
        // 获取管理员id
        $id = $manager->id;
        // 根据用户id查询角色id组
        $permissions = $permissionService->getPermissionByManagerId($id);

        $tree = $permissionService->getTreeForMenu($permissions);

        return send_msg_json(SUCCESS_RETURN, "success", $tree);
    }
}
