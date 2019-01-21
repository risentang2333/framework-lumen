<?php

namespace App\Services\Admin;

use App\Entities\Staff;
use App\Entities\Areas;
use App\Entities\StaffSkills;
use App\Entities\ServiceCategories;
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
        return ServiceCategories::get()->keyBy('id')->toArray();
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
        $list = DB::table('staff')->select(['id','name','phone','icon','age','address','version'])
            ->where(function ($query) use ($params){
                // 逻辑删除判断
                $query->where('status', 0);
                // 如果有姓名搜索项
                if ($params['name']) {
                    $query->where('name','like','%'.$params['name'].'%');
                }
                // 根据服务类型筛选
                if ($params['label_id']) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_skills` WHERE `service_id` = ?)', [$params['label_id']]);
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
        $objStaff = Staff::select(['id','name','phone','icon','age','address','version'])
            ->where(['status'=>0,'id'=>$id])->first();
        if (empty($objStaff)) {
            send_msg_json(ERROR_RETURN, "该服务人员不存在");
        }
        $staff = $objStaff->toArray();

        $label = StaffSkills::select(['id','staff_id','service_id','name','level'])->get()->toArray();

        $data = array(
            "staff" => $staff,
            "label" => $label
        );

        return $data;
    }


    /**
     * 根据手机号查询员工
     *
     * @param string $phone
     * @return object
     */
    public function getStaffByPhone($phone)
    {
        $staff = Staff::select(['id','name','phone','icon','age','address','version'])
            ->where(['status'=>0,'phone'=>$phone])->first();
        
        return $staff;
    }

    /**
     * 保存服务人员
     *
     * @param array $params
     * @return string
     */
    public function saveStaff($params)
    {
        $returnMsg = '';
        DB::transaction(function () use (&$returnMsg, $params){
            if ($params['id'] == '') {
                if (!empty($this->getStaffByPhone($params['phone']))) {
                    DB::rollback();
                    send_msg_json(ERROR_RETURN, "该服务人员已存在");
                }
                $staff = new Staff;
                $staff->created_at = time();
                $returnMsg = '添加成功';
            } else {
                $staff = Staff::where('status', 0)->find($params['id']);
                if (empty($staff)) {
                    DB::rollback();
                    send_msg_json(ERROR_RETURN, "该服务人员不存在");
                }
                if ($staff->version != $params['version']) {
                    DB::rollback();
                    send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
                }
                $staff->version = $params['version']+1;
                $returnMsg = '编辑成功';
            }

            $staff->id_number = $params['id_number'];
            $staff->name = $params['name'];
            $staff->phone = $params['phone'];
            $staff->age = $params['age'];
            $staff->bank_card = $params['bank_card'];
            $staff->address = $params['address'];
    
            $staff->save();
            // staff表操作id
            $staffId = $staff->id;
            // 标签数组
            $labels = json_decode($params['labels'], true);
            foreach ($labels as $key => $value) {
                DB::table('staff_skills')->insert(['staff_id'=>$staffId, 'service_id'=>$value['id'], 'name'=>$value['name'], 'level'=>$value['level']]);
            }
        });

        return $returnMsg;
    }

    
}
