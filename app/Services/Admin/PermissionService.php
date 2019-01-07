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
    private $roleManagerData = [
        'role_manager.id',
        'role_manager.manager_id',
        'role_manager.role_id',
        'managers.name as manager_name',
        'roles.name as role_name',
    ];

    private $permissionData = [
        'id',
        'route',
        'name',
        'description',
        'icon',
        'sort_order',
        'parent_id',
        'is_display',
    ];

    public function getRoleManager()
    {
        $data = RoleManager::leftjoin('managers', function ($join) {
            $join->on('manager_id','managers.id');
        })->rightjoin('roles', function ($join) {
            $join->on('role_id','roles.id');
        })->select($this->roleManagerData)->get()->toArray();
    
        return $data;
    }

    public function getPermissionRole()
    {
        $data = PermissionRole::leftjoin('permissions', function ($join) {
            $join->on('permission_id','permissions.id');
        })->rightjoin('roles', function ($join) {
            $join->on('role_id','roles.id');
        })->select($this->permissionRoleData)->get()->toArray();

        return $data;
    }

    // 根据用户id查询用户绑定的角色id
    public function getRoleIdsByManagerId($id)
    {
        $data = RoleManager::where('manager_id',$id)->pluck('role_id')->toArray();
        
        return $data;
    }

    public function getPermissionByRoleIds($roleIds)
    {
        $permissionIds = PermissionRole::whereIn('role_id',$roleIds)->pluck('permission_id');

        $data = Permissions::select(['id','name','parent_id'])
                        ->whereIn('id',$permissionIds)
                        ->where('is_display',1)
                        ->orderBy('sort_order','ASC')
                        ->get()
                        ->keyBy('id')
                        ->toArray();
        return $data;
    }

    public function getPermissionByManagerId($id)
    {
        $roleIds = RoleManager::where('manager_id',$id)->pluck('role_id')->toArray();

        $permissionIds = PermissionRole::whereIn('role_id',$roleIds)->pluck('permission_id');

        $data = Permissions::select(['id','name','parent_id'])
                        ->whereIn('id',$permissionIds)
                        ->where('is_display',1)
                        ->orderBy('sort_order','ASC')
                        ->get()
                        ->keyBy('id')
                        ->toArray();
        return $data;
    }

    /**
     * 获取所有权限
     *
     * @return void
     */
    public function getPermission()
    {
        $data = Permissions::select(['id','name','parent_id'])
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

    public function getRoleList($paginate = true, $pageNumber = 20)
    {
        $data = Roles::get()->toArray();

        return $data;
    }

    /**
     * 重新分配用户和角色关系
     *
     * @param [type] $id
     * @param [type] $role
     * @return void
     */
    public function allotManagerRole($id, $role)
    {
        DB::transaction(function () use ($id, $role){
            // 先把关系表中与管理员id有关的删除
            DB::delete("DELETE FROM `role_manager` WHERE `manager_id` = $id");
            // 重新生成新关系
            foreach ($role as $value) {
                DB::table('role_manager')->insert([
                    'manager_id' => $id,
                    'role_id' => $value,
                ]);
            }
        });
        return true;
    }

    public function getManagerList($pageNumber = 20)
    {
        $data = Managers::paginate($pageNumber)->toArray();

        return $data;
    }

    public function getPermissionList($pageNumber = 20)
    {
        $data = Permissions::paginate($pageNumber)->toArray();

        return $data;
    }

    public function getPermissionById($id)
    {
        $data = Permissions::find($id)->toArray();
        
        return $data;
    }
}
