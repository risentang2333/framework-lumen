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
        'type',
        'parent_id',
        'version'
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
                // 启用/禁用
                if ($params['type']) {
                    $query->where('type', $params['type']);
                }
            })
            ->paginate($pageNumber)
            ->toArray();
        return $list;
    }

    public function getAbilityById($id)
    {
        $ability = Abilities::select(['id','name','parent_id','type','version'])
            ->where(['status'=>0,'id'=>$id])->first();
        if (empty($ability)) {
            send_msg_json(ERROR_RETURN, "该能力标签不存在");
        }
        return $ability;
    }

    public function getAbilityForTree()
    {
        $data = Abilities::select(['id','name','parent_id'])
                    ->where('status', 0)
                    ->get()
                    ->keyBy('id')
                    ->toArray();
        return $data;
    }

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
            if (isset($value['children'])) {
                if ($ids == 0) {
                    $this->visitTree($items[$key]['children'], $value['id'], $value['name']);
                } else {
                    $this->visitTree($items[$key]['children'], $ids.'-'.$value['id'], $names.'>'.$value['name']);
                }
            }
        }
        
        return $selection;
    }

    public function saveAbility($params)
    {
        $returnMsg = '';
        if (empty($params['id'])) {
            $ability = new Abilities;
            $returnMsg = '添加成功';
        } else {
            $ability = Abilities::where('status', 0)->find($params['id']);
            if (empty($ability)) {
                send_msg_json(ERROR_RETURN, "该能力标签不存在");
            }
            if ($ability->version != $params['version']) {
                send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
            }
            // 版本号+1
            $ability->version = $params['version']+1;
            // 返回信息
            $returnMsg = '编辑成功';
        }
        // 服务分类id
        $ability->parent_id = $params['parent_id'];
        // 服务分类名
        $ability->name = $params['name'];

        $ability->type = $params['type'];

        DB::transaction(function () use ($ability, $params) {
            // 保存
            $ability->save();
            // 获取所有分类
            $abilities = $this->getAbilityForTree();
            // 生成树
            $tree = getTree($abilities, false);
            // 需要改变状态的树
            $changeTree = filterTreeById($tree, $ability->id);
            // 需要改变状态的id集合
            $changeIds = getFilterIds($changeTree);
            // 判断状态格式
            $this->changeAbilityType($changeIds, $params['type'], $ability->version);
        });

        return array(
            'returnMsg'=>$returnMsg,
            'abilityId'=>$ability->id
        );
    }

    public function changeAbilityType($changeIds, $type, $version)
    {
        // 启用/禁用所有节点分类
        DB::table('abilities')->where('status', 0)->whereIn('id', $changeIds)->update(['type'=>$type, 'version'=>$version+1]);
        // 返回信息
        $returnMsg = $type == 'enable' ? '启用成功' : '禁用成功';

        return $returnMsg;
    }

    public function deleteAbility($deleteIds)
    {
        // 逻辑删除权限表
        DB::table('abilities')->whereIn('id', $deleteIds)->update(['status'=>1, 'version'=>$version+1]);

        return true;
    }

    public function checkSameName($name)
    {
        $count = Abilities::where(['name'=>$name, 'status'=>0])->count();

        if (empty($count)) {
            return false;
        } else {
            return true;
        }
    }
}
