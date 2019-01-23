<?php

namespace App\Services\Admin;

use App\Entities\Staff;
use App\Entities\Areas;
use App\Entities\StaffSkills;
use App\Entities\StaffLabels;
use App\Entities\ServiceCategories;
use App\Entities\StaffPapers;
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
                if ($params['service_category_id'] && empty($params['ability_ids'])) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_skills` WHERE `service_category_id` = ?) AND `status` = 0', [$params['service_category_id']]);
                }
                // 根据特长标签搜索
                if ($params['ability_ids'] && empty($params['service_category_id'])) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_labels` WHERE `ability_id` IN (?) AND `status` = 0', [implode(",",$params['ability_ids'])]);
                }
                // 如果服务类型特长都存在
                if ($params['ability_ids'] && $params['service_category_id']) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_skill_label` WHERE `skill_id` in (SELECT `id` FROM `staff_skills` WHERE `service_category_id` = ? AND `status` = 0) AND `label_id` IN (SELECT `id` FROM `staff_labels` WHERE `ability_id` IN (?) AND `status` = 0))', [$params['service_category_id'], implode(",",$params['ability_ids'])]);
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
        $staff = Staff::select(['id','name','phone','icon','age','address','bank_card','version'])
            ->where(['status'=>0,'id'=>$id])->first();
        if (empty($staff)) {
            send_msg_json(ERROR_RETURN, "该服务人员不存在");
        }

        return $staff;
    }

    /**
     * 根据员工id获取证书
     *
     * @param int $id
     * @return object
     */
    public function getPaperByStaffId($id)
    {
        // 证书
        $paper = StaffPapers::where(['staff_id'=>$id, 'status'=>0])->get();

        return $paper;
    }

    /**
     * 根据员工id获取能力标签
     *
     * @param int $id
     * @return object
     */
    public function getLabelByStaffId($id)
    {
        $label = StaffLabels::where(['staff_id'=>$id, 'status'=>0])->get();

        return $label;
    }

    /**
     * 根据员工id获取技能标签材料证明集合
     *
     * @param int $id
     * @return array
     */
    public function getSkillLabelPaperByStaffId($id)
    {
        $skill = StaffSkills::where(['staff_id'=>$id, 'status'=>0])->get()->toArray();

        if (!empty($skill)) {
            foreach ($skill as $key => $value) {
                // 查询技能所对应的标签
                $label = DB::table('staff_labels')->where('status',0)->whereRaw('`id` IN (SELECT `label_id` FROM `staff_skill_label` WHERE `staff_id` = ? AND `skill_id` = ?)', [$id, $value['id']])->get()->toArray();
                // 查询技能所对应的证书
                $paper = DB::table('staff_papers')->where('status',0)->whereRaw('`id` IN (SELECT `paper_id` FROM `staff_skill_paper` WHERE `staff_id` = ? AND `skill_id` = ?)', [$id, $value['id']])->get()->toArray();
                // 如果标签不为空，放入对应的技能中
                if (!empty($label)) {
                    $skill[$key]['label'] = $label;
                }
                if (!empty($paper)) {
                    $skill[$key]['paper'] = $paper;
                }
            }
        }

        return $skill;
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
                DB::table('staff_skills')->updateOrInsert(['staff_id'=>$staffId, 'service_category_id'=>$value['id'], 'status'=>0],['staff_id'=>$staffId, 'service_category_id'=>$value['id'], 'name'=>$value['name'], 'level'=>$value['level'], 'workable'=>$value['workable'], 'review'=>$value['review']]);
            }
        });

        return $returnMsg;
    }
}
