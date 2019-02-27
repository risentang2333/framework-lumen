<?php

namespace App\Services\Admin;

use App\Entities\PaperCategories;
use Illuminate\Support\Facades\DB;

class PaperService 
{    
    public function getCategoryList($params, $pageNumber = 15)
    {
        $list = PaperCategories::select(['id','name','code','type'])
            ->where(function ($query) use ($params){
                // 逻辑删除判断
                $query->where('status', 0);
                // 如果有姓名搜索项
                if ($params['name']) {
                    $query->where('name','like','%'.$params['name'].'%');
                }
                // 启用/禁用
                if ($params['type']) {
                    $query->where('type', $params['type']);
                }
            })
            ->paginate($pageNumber)
            ->toArray();
        return $list;
    }

    public function getCategoryById($id)
    {
        $paperCategory = PaperCategories::select(['id','name','code','type','version'])
            ->where(['status'=>0,'id'=>$id])->first();
        if (empty($paperCategory)) {
            send_msg_json(ERROR_RETURN, "该证件类型不存在");
        }
        return $paperCategory;
    }

    public function saveCategory($params)
    {
        $returnMsg = '';
        if (empty($params['id'])) {
            $paperCategory = new PaperCategories;
            $returnMsg = '添加成功';
        } else {
            $paperCategory = PaperCategories::where('status', 0)->find($params['id']);
            if (empty($paperCategory)) {
                send_msg_json(ERROR_RETURN, "该证件类型不存在");
            }
            if ($paperCategory->version != $params['version']) {
                send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
            }
            // 版本号+1
            $paperCategory->version = $params['version']+1;
            // 返回信息
            $returnMsg = '编辑成功';
        }
        // 证件类型码
        $paperCategory->code = $params['code'];
        // 证件类型名
        $paperCategory->name = $params['name'];
        // 启用/禁用
        $paperCategory->type = $params['type'];
        // 保存
        $paperCategory->save();

        return array(
            'returnMsg'=>$returnMsg,
            'paperId'=>$paperCategory->id
        );
    }

    public function changeCategoryType($id, $type, $version)
    {
        $paperCategory = PaperCategories::where('status', 0)->find($id);
        if ($paperCategory->version != $version) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        $paperCategory->type = $type;
        $paperCategory->version = $version+1;
        // 返回信息
        $returnMsg = $type == 'enable' ? '启用成功' : '禁用成功';

        return $returnMsg;
    }
}
