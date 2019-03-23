<?php

namespace App\Services\Admin;

use App\Entities\ServiceCategories;
use App\Entities\Abilities;
use App\Entities\Areas;
use App\Entities\PaperCategories;
use App\Entities\Managers;
use Illuminate\Support\Facades\DB;

class CommonService 
{
    /**
     * 获取标签作为生成树结构前提
     *
     * @return array
     */
    public function getLabelForTree($type = '')
    {
        return Abilities::select(['id','name','parent_id'])
                    ->where(function ($query) use ($type) {
                        $query->where('status', 0);
                        // 只查询已经启用的
                        if ($type == 'enable') {
                            $query->where('type', 'enable');
                        }
                    })
                    ->get()
                    ->keyBy('id')
                    ->toArray();
    }

    /**
     * 获取工种作为生成树结构前提
     *
     * @return void
     */
    public function getCategoryForTree($type = '')
    {
        return ServiceCategories::select(['id','name','parent_id'])
                    ->where(function ($query) use ($type) {
                        $query->where('status', 0);
                        // 只查询已经启用的
                        if ($type == 'enable') {
                            $query->where('type', 'enable');
                        }
                    })
                    ->get()
                    ->keyBy('id')
                    ->toArray();
    }

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
     * 获取证书类型
     *
     * @return array
     */
    public function getPaperSelection($type = '')
    {
        return PaperCategories::where(function ($query) use ($type){
            $query->where('status',0);

            if ($type == 'enable') {
                $query->where('type', 'enable');
            }
        })
        ->get()
        ->toArray();
    }

    /**
     * 获取管理员下拉数据
     *
     * @return array
     */
    public function getManagerSelection()
    {
        return Managers::select(['id as manager_id','name as manager_name'])->where('status',0)->get()->toArray();
    }
}
