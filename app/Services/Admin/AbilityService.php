<?php

namespace App\Services\Admin;

use App\Entities\Abilities;
use Illuminate\Support\Facades\DB;

class AbilityService 
{
    /**
     * 员工列表查询字段
     *
     * @var array
     */
    private $itemList = [
        'id',
        'name',
        'parent_id',
    ];
    
    public function getAbilityList($params, $pageNumber = 15)
    {
        $list = Abilities::select($this->itemList)
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
