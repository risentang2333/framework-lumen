<?php

namespace App\Services\Admin;

use App\Entities\staff;
use App\Entities\Areas;
use Illuminate\Support\Facades\DB;

class StaffService 
{
    /**
     * 获取地区
     *
     * @return array
     */
    public function getAreaForTree()
    {
        return Areas::get()->keyBy('id')->toArray();
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
     * 获取员工列表
     *
     * @param array $params
     * @return array
     */
    public function getStaffList($params, $pageNumber = 15)
    {
        $list = staff::select(['id','account','name'])
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
}
