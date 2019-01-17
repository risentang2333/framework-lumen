<?php

namespace App\Services\Admin;

use App\Entities\staff;
use App\Entities\Areas;
use App\Entities\StaffCategory;
use Illuminate\Support\Facades\DB;

class StaffService 
{
    /**
     * 获取地区作为生成树结构前提
     *
     * @return array
     */
    public function getAreaForTree()
    {
        return Areas::get()->keyBy('id')->toArray();
    }

    /**
     * 获取工种作为生成树结构前提
     *
     * @return void
     */
    public function getCategoryForTree()
    {
        return StaffCategory::get()->keyBy('id')->toArray();
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
                $items[$item['parent_id']]['children'][] = &$items[$item['id']];
            }else{
                $tree[] = &$items[$item['id']];
            }
        }
        return $tree;
    }

    /**
     * 获取员工列表
     *
     * @param array $params
     * @return array
     */
    public function getStaffList($params, $pageNumber = 15)
    {
        $list = staff::select(['id','name','phone','icon','age','level','address','category','version'])
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

        return $list;
    }

    /**
     * 根据服务人员id查询服务人员信息
     *
     * @param  $id
     * @return void
     */
    public function getStaffById($id)
    {
        $data = staff::select(['id','name','phone','icon','age','level','address','category','version'])
                    ->where(['status'=>0,'id'=>$id])->first();
        if (empty($data)) {
            send_msg_json(ERROR_RETURN, "该服务人员不存在");
        }

        return $data;
    }

    /**
     * 保存服务人员
     *
     * @param array $params
     * @return string
     */
    public function saveStaff($params)
    {
        if ($params['id'] == '') {
            $staff = new Staff;
            $returnMsg = '添加成功';
        } else {
            $staff = Staff::where('status', 0)->find($params['id']);
            if (empty($staff)) {
                send_msg_json(ERROR_RETURN, "该服务人员不存在");
            }
            if ($staff->version != $params['version']) {
                send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
            }
            $staff->version = $params['version']+1;
            $returnMsg = '编辑成功';
        }

        $staff->name = $params['name'];
        $staff->phone = $params['phone'];
        $staff->age = $params['age'];
        $staff->level = $params['level'];
        $staff->address = $params['address'];
        $staff->category = $params['category'];

        $staff->save();

        return $returnMsg;
    }
}
