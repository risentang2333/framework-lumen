<?php

namespace App\Services\Admin;

use App\Entities\Managers;
use App\Entities\RoleManager;
use App\Entities\Roles;
use App\Entities\PermissionRole;
use App\Entities\Permissions;
use Illuminate\Support\Facades\DB;

class PermissionService 
{
    /**
     * 获取管理员列表
     *
     * @param integer $pageNumber
     * @return array
     */
    public function getManagerList($params, $pageNumber = 20)
    {
        $data = Managers::select(['id','account','name'])
                        ->where(function ($query) use ($params){
                            // 逻辑删除判断
                            $query->where('status', 0);
                            // 如果有姓名搜索项
                            if ($params['name']) {
                                $query->where('name','like','%'.$params['name'].'%');
                            }
                        })
                        ->paginate($pageNumber)
                        ->toArray();

        return $data;
    }

    /**
     * 获取角色列表
     *
     * @param boolean $paginate 可带分页或不分页
     * @param integer $pageNumber
     * @return void
     */
    public function getRoleList($paginate = true, $pageNumber = 15)
    {
        if ($paginate) {
            $data = Roles::where('status', 0)->paginate($pageNumber);
        } else {
            $data = Roles::where('status', 0)->get();
        }

        return $data->toArray();
    }

    /**
     * 根据用户id查询用户绑定的角色id
     *
     * @param int $id
     * @return array
     */
    public function getRoleIdsByManagerId($id)
    {
        $data = RoleManager::where('manager_id',$id)->pluck('role_id')->toArray();
        
        return $data;
    }

    /**
     * 重新分配用户和角色关系
     *
     * @param [type] $id
     * @param [type] $role
     * @return void
     */
    public function editManagerRole($id, $roleIds)
    {
        DB::transaction(function () use ($id, $roleIds){
            // 先把关系表中与管理员id有关的删除
            DB::delete("DELETE FROM `role_manager` WHERE `manager_id` = $id");
            // 重新生成新关系
            foreach ($roleIds as $value) {
                DB::table('role_manager')->insert([
                    'manager_id' => $id,
                    'role_id' => $value,
                ]);
            }
        });
        return true;
    }

    /**
     * 获取管理员信息
     *
     * @param int $id
     * @return array
     */
    public function getManagerById($id)
    {
        $manager = Managers::where('status', 0)->find($id);
        
        return $manager;
    }

    /**
     * 编辑管理员信息
     *
     * @param int $id
     * @param string $name
     * @param string $password
     * @return boolean
     */
    public function saveManager($id, $name, $account, $password)
    {
        if ($id == '') {
            $manager = new Managers;
            $manager->account = $account;
        } else {
            $manager = Managers::where('status',0)->find($id);
            if (empty($manager)) {
                send_msg_json(ERROR_RETURN, "该管理员不存在");
            }
        }

        $manager->name = $name;
        if ($password != '') {
            // 加密后密码
            $encryptPwd = md5('manager'.$password);
            // 新token
            $accessToken = md5(time().$manager->account);
            // 新刷新token
            $refreshToken = md5(time().'refresh'.$manager->account);

            $manager->password = $encryptPwd;
            $manager->access_token = $accessToken;
            $manager->refresh_token = $refreshToken;
        }

        return $manager->save();
    }


    /**
     * 物理删除管理员
     *
     * @param int $id
     * @return boolean
     */
    public function deleteManager($id)
    {
        DB::transaction(function () use ($id){
            // 逻辑删除管理员表中管理员数据
            DB::table('managers')->where('id', $id)->update(['status'=>1]);
            // 物理删除角色管理员关系表中数据
            RoleManager::where('manager_id', $id)->delete();
        });
        return true;
    }

    /**
     * 根据roleId获取角色信息
     *
     * @param int $id
     * @return array
     */
    public function getRoleByRoleId($id)
    {
        $role = Roles::where('status', 0)->find($id);
        
        return $role;
    }

    /**
     * 编辑角色
     *
     * @param int $id
     * @param string $name
     * @return boolean
     */
    public function saveRole($id, $name)
    {
        if ($id == '') {
            $role = new Roles;
        } else {
            $role = Roles::where('status', 0)->find($id);
            if (empty($role)) {
                send_msg_json(ERROR_RETURN, "该角色不存在");
            }
        }
        
        $role->name = $name;

        return $role->save();
    }


    /**
     * 物理删除角色
     *
     * @param int $id
     * @return boolean
     */
    public function deleteRole($id)
    {
        DB::transaction(function () use ($id){
            // 逻辑删除角色表数据
            DB::table('roles')->where('id', $id)->update(['status'=>1]);
            // 物理删除角色管理员关系表
            RoleManager::where('role_id', $id)->delete();
            // 物理删除角色权限关系表
            PermissionRole::where('role_id', $id)->delete();
        });
        return true;
    }

    /**
     * 获取权限列表，可分页，可所有
     *
     * @param boolean $paginate
     * @param integer $pageNumber
     * @return void
     */
    public function getPermissionList($paginate = true, $pageNumber = 20)
    {
        if ($paginate) {
            $data = Permissions::where('status',0)->paginate($pageNumber);
        } else {
            $data = Permissions::where('status',0)->select(['id', 'route', 'name'])->get();
        }

        return $data->toArray();
    }

    /**
     * 根据角色id获取相对应的权限id
     *
     * @param int $id
     * @return array
     */
    public function getRolePermissionByRoleId($id)
    {
        $rolePermission = PermissionRole::where('role_id', $id)->pluck('permission_id')->toArray();

        return $rolePermission;
    }

    /**
     * 编辑角色权限
     *
     * @param int $id
     * @param array $permissions
     * @return string
     */
    public function editRolePermission($id, $permissionIds)
    {
        DB::transaction(function () use ($id, $permissionIds){
            // 先把关系表中与角色id有关的删除
            DB::delete("DELETE FROM `permission_role` WHERE `role_id` = $id");
            // 重新生成新关系
            foreach ($permissionIds as $value) {
                DB::table('permission_role')->insert([
                    'role_id' => $id,
                    'permission_id' => $value,
                ]);
            }
        });
        return true;
    }

    /**
     * 根据权限id获取权限信息
     *
     * @param int $id
     * @return array
     */
    public function getPermissionById($id)
    {
        $data = Permissions::where('status',0)->find($id);

        return $data;
    }

    /**
     * 获取所有权限为树形结构做准备
     *
     * @return void
     */
    public function getPermissionForTree($selectAll = true)
    {
        $data = Permissions::select(['id','name','parent_id'])
                        ->where(function ($query) use ($selectAll) {
                            $query->where('status', 0);
                            if (!$selectAll) {
                                $query->where('is_api', 0);
                            }
                        })
                        ->orderBy('sort_order','ASC')
                        ->get()
                        ->keyBy('id')
                        ->toArray();
        return $data;
    }

    /**
     * 生成树结构
     *
     * @param array $items
     * @return array
     */
    public function getTree($items)
    {
        $tree = array();
        foreach($items as $item){
            if(isset($items[$item['parent_id']])){
                $items[$item['parent_id']]['son'][] = &$items[$item['id']];
            }else{
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }

    /**
     * 遍历树结构每个节点，生成“父节点-子节点”结构
     *
     * @param array $items
     * @param integer $ids
     * @param string $names
     * @return array
     */
    public function visitTree($items, $ids = 0, $names = '')
    {
        // static $selection = array();
        static $selection = array(["id"=>0, "ids"=>"0", "names"=>"基础"]);
        $temp = array();
        foreach ($items as $key => $value) {
            if ($ids == 0) {
                $temp['id'] = $value['id'];
                $temp['ids'] = (string)$value['id'];
                $temp['names'] = $value['name'];
            } else {
                $temp['id'] = $value['id'];
                $temp['ids'] = $ids.'-'.$value['id'];
                $temp['names'] = $names.'>'.$value['name'];
            }
            array_push($selection, $temp);
            if (isset($value['son'])) {
                if ($ids == 0) {
                    $this->visitTree($items[$key]['son'], $value['id'], $value['name']);
                } else {
                    $this->visitTree($items[$key]['son'], $ids.'-'.$value['id'], $names.'>'.$value['name']);
                }
            }
        }
        
        return $selection;
    }

    public function deletePermission($id)
    {
        DB::transaction(function () use ($id){
            // 逻辑删除权限表
            DB::table('permissions')->where('id', $id)->update(['status'=>1]);
            // 物理删除权限角色关系表
            PermissionRole::where('permission_id', $id)->delete();
        });
        return true;
    }

    /**
     * 根据用户id获取相对应的权限数据
     *
     * @param int $id
     * @return array
     */
    public function getPermissionByManagerId($id)
    {
        $roleIds = RoleManager::where('manager_id',$id)->pluck('role_id')->toArray();

        $permissionIds = PermissionRole::whereIn('role_id',$roleIds)->pluck('permission_id');

        $data = Permissions::select(['id','name','route','parent_id'])
                        ->whereIn('id',$permissionIds)
                        ->where(['is_display'=>1, 'status'=>0])
                        ->orderBy('sort_order','ASC')
                        ->get()
                        ->keyBy('id')
                        ->toArray();
        return $data;
    }

    /**
     * 编辑权限
     *
     * @param [type] $params
     * @return void
     */
    public function editPermission($params)
    {
        $permission = Permissions::where('status',0)->find($params['id']);
        if (empty($permission)) {
            send_msg_json(ERROR_RETURN, "该权限不存在");
        }
        $permission->route = $params['route'];
        $permission->name = $params['name'];
        $permission->description = $params['description'];
        $permission->icon = $params['icon'];
        $permission->sort_order = $params['sort_order'];
        $permission->parent_id = $params['parent_id'];
        $permission->is_display = $params['is_display'];
        $permission->is_api = $params['is_api'];

        return $permission->save();
    }

    /**
     * 根据accesstoken获取用户信息
     *
     * @param [type] $accessToken
     * @return void
     */
    public function getManagerByAccessToken($accessToken)
    {
        $manager = Managers::where(['access_token'=>$accessToken, 'status'=>0])->first();
        
        return $manager;
    }
}
