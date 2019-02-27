<?php

namespace App\Services\Admin;

use App\Entities\ServiceCategories;
use App\Entities\Abilities;
use App\Entities\Areas;
use App\Entities\PaperCategories;
use Illuminate\Support\Facades\DB;

class CommonService 
{
    /**
     * 获取标签作为生成树结构前提
     *
     * @return array
     */
    public function getLabelForTree()
    {
        return Abilities::select(['id','name','parent_id'])
                    ->where('status', 0)
                    ->get()
                    ->keyBy('id')
                    ->toArray();
    }

    /**
     * 获取工种作为生成树结构前提
     *
     * @return void
     */
    public function getCategoryForTree()
    {
        return ServiceCategories::select(['id','name','parent_id'])
                    ->where(['type'=>'enable', 'status'=>0])
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
    public function getPaperSelection()
    {
        return PaperCategories::where('status', 0)->get()->toArray();
    }
}
