<?php

namespace App\Services\Admin;

use App\Entities\Staff;
use App\Entities\Areas;
use App\Entities\StaffSkills;
use App\Entities\StaffLabels;
use App\Entities\AbilityCategories;
use App\Entities\ServiceCategories;
use App\Entities\StaffPapers;
use Illuminate\Support\Facades\DB;

class StaffService 
{
    /**
     * 员工技能列表查询字段
     *
     * @var array
     */
    private $staffSkillList = [
        "staff_skills.id",
        "staff_skills.staff_id",
        "staff.name as staff_name",
        "staff.address",
        "staff_skills.service_category_id",
        "staff_skills.name",
        "staff_skills.level",
        "staff_skills.workable",
        "staff_skills.review",
        "staff_skills.version",
    ];

    /**
     * 员工列表查询字段
     *
     * @var array
     */
    private $staffList = [
        'id',
        'name',
        'phone',
        'age',
        'address',
        'version'
    ];
    
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

    public function getLabelForTree()
    {
        return AbilityCategories::get()->keyBy('id')->toArray();
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
        $list = Staff::select($this->staffList)
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
        if (empty($params['id'])) {
            if (!empty($this->getStaffByPhone($params['phone']))) {
                send_msg_json(ERROR_RETURN, "该服务人员已存在");
            }
            $staff = new Staff;
            $staff->created_at = time();
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
        $staff->bank_card = $params['bank_card'];
        $staff->address = $params['address'];
        // 保存并获取操作id
        $staffId = DB::transaction(function () use ($staff, $params){
            $staff->save();
            // staff表操作id
            $staffId = $staff->id;
            // 编辑员工能力标签
            $this->saveStaffLabel($params['labels'], $params['id'], $staffId);
            // 编辑员工证件
            $this->saveStaffPaper($params['papers'], $params['id'], $staffId);
            // 编辑员工技能
            $this->saveStaffSkill($params['skills'], $params['id'], $staffId);

            return $staffId;
        });

        return array(
            'returnMsg'=>$returnMsg,
            'staffId'=>$staffId
        );
    }

    /**
     * 编辑员工能力标签
     *
     * @param array $labels
     * @param int $staffId
     * @return boolean
     */
    private function saveStaffLabel($labels, $formId, $staffId)
    {
        // 如果为添加表单
        if (empty($formId)) {
            if (!empty($labels)) {
                array_walk($labels, function (&$item) use ($staffId){
                    DB::table('staff_labels')->insert(['staff_id'=>$staffId,'ability_id'=>$item['ability_id'],'name'=>$item['name']]);
                });
            }
        // 如果为编辑表单
        } else {
            $labelIds = array_column($labels, 'id');
            // 原关系id集合
            $original_labelIds = DB::table('staff_labels')->select('id')->where('staff_id', $staffId)->pluck('id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($labelIds, $original_labelIds);
            // 需要删除的标签id
            $delete_labelIds = implode(",", array_diff($original_labelIds, $array_intersect));
            if (!empty($delete_labelIds)) {
                // 先逻辑删除员工标签表
                DB::delete("UPDATE `staff_labels` SET `status` = 1 WHERE `id` IN ($delete_labelIds)");
                // 再物理删除员工技能标签关系表
                DB::delete("DELETE FROM `staff_skill_label` WHERE `staff_id` = $staffId AND `label_id` IN ($delete_labelIds)");
            }

            if (!empty($labels)) {
                array_walk($labels, function (&$item) use ($staffId, $array_intersect){
                    if (!in_array($item['id'], $array_intersect)) {
                        DB::table('staff_labels')->insert(['staff_id'=>$staffId,'ability_id'=>$item['ability_id'],'name'=>$item['name']]);
                    }
                });
            }
        }
        
        return true;
    }

    /**
     * 保存员工证件
     *
     * @param array $papers
     * @param int $staffId
     * @return boolean
     */
    private function saveStaffPaper($papers, $staffId)
    {
        return true;
    }

    /**
     * 保存员工技能
     *
     * @param int $skills
     * @param int $formId 表单id，来判断是添加还是编辑
     * @param int $staffId
     * @return void
     */
    private function saveStaffSkill($skills, $formId, $staffId)
    {
        if (empty($formId)) {
            if (!empty($skills)) {
                array_walk($skills, function (&$item) use ($staffId){
                    DB::table('staff_skills')->insert(['staff_id'=>$staffId,'service_category_id'=>$item['service_category_id'],'name'=>$item['name'],'level'=>$item['level'],'workable'=>$item['workable'],'review'=>0]);
                    // 获取每一条技能的操作id
                    $skillId = DB::getPdo()->lastInsertId();
                    // 编辑员工技能与标签关系表
                    $this->saveStaffSkillLabel($item['labels'], $staffId, $skillId);
                    // 编辑员工技能与材料关系表
                    // $this->saveStaffSkillPaper($item['papers'], $staffId, $skillId);
                });
            }
        } else {
            $skillIds = array_column($skills, 'id');
            // 原关系id集合
            $original_skillIds = DB::table('staff_skills')->select('id')->where('staff_id', $staffId)->pluck('id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($skillIds, $original_skillIds);
            // 需要删除的标签id
            $delete_skillIds = implode(",", array_diff($original_skillIds, $array_intersect));
            if (!empty($delete_skillIds)) {
                // 先逻辑删除员工标签表
                DB::delete("UPDATE `staff_skills` SET `status` = 1 WHERE `id` IN ($delete_skillIds)");
                // 再物理删除员工技能标签关系表
                DB::delete("DELETE FROM `staff_skill_label` WHERE `staff_id` = $staffId AND `skill_id` IN ($delete_skillIds)");
            }
            if (!empty($skills)) {
                array_walk($skills, function (&$item) use ($staffId, $array_intersect){
                    if (!in_array($item['id'], $array_intersect)) {
                        DB::table('staff_skills')->insert(['staff_id'=>$staffId,'service_category_id'=>$item['service_category_id'],'name'=>$item['name'],'level'=>$item['level'],'workable'=>$item['workable'],'review'=>0]);
                    }
                    // 获取每一条技能的操作id
                    if (empty($item['id'])) {
                        $skillId = DB::getPdo()->lastInsertId();
                    } else {
                        $skillId = $item['id'];
                    }
                    // 编辑员工技能与标签关系表
                    $this->saveStaffSkillLabel($item['labels'], $staffId, $skillId);
                    // 编辑员工技能与材料关系表
                    // $this->saveStaffSkillPaper($item['papers'], $staffId, $skillId);
                });
            }
        }
        return true;
    }

    /**
     * 编辑技能与标签关系表
     *
     * @param array $labels
     * @param int $staffId
     * @param int $skillId
     * @return boolean
     */
    private function saveStaffSkillLabel($labels, $staffId, $skillId)
    {
        // 获取需要编辑的标签id集合
        $labelIds = array_column($labels, 'id');
        // 原关系id集合
        $original_labelIds = DB::table('staff_skill_label')->select('label_id')->where(['staff_id'=>$staffId,'skill_id'=>$skillId])->pluck('label_id')->toArray();
        // 原关系数组与新数组交集
        $array_intersect = array_intersect($labelIds, $original_labelIds);
        // 需要删除的标签id
        $delete_labelIds = implode(",", array_diff($original_labelIds, $array_intersect));
        // 需要添加的标签id
        $add_labelIds = array_diff($labelIds, $array_intersect);
        // 如果存在删除的权限角色关系
        if (!empty($delete_labelIds)) {
            // 先把关系表中需要删除的删除
            DB::delete("DELETE FROM `staff_skill_label` WHERE `staff_id` = $staffId AND `skill_id` = $skillId AND `label_id` IN ($delete_labelIds)");
        }
        if (!empty($add_labelIds)) {
            // 重新生成新关系
            foreach ($add_labelIds as $value) {
                DB::table('staff_skill_label')->insert([
                    'staff_id' => $staffId,
                    'skill_id' => $skillId,
                    'label_id' => $value,
                ]);
            }
        }

        return true;
    }

    /**
     * 保存技能材料关系表
     *
     * @param array $papers
     * @param int $staffId
     * @param int $skillId
     * @return boolean
     */
    private function saveStaffSkillPaper($papers, $staffId, $skillId)
    {
        // 获取需要编辑的材料id集合
        $paperIds = array_column($papers, 'id');
        // 原关系id集合
        $original_paperIds = DB::table('staff_skill_paper')->select('paper_id')->where(['staff_id'=>$staffId,'skill_id'=>$skillId])->pluck('paper_id')->toArray();
        // 原关系数组与新数组交集
        $array_intersect = array_intersect($paperIds, $original_paperIds);
        // 需要删除的标签id
        $delete_paperIds = implode(",", array_diff($original_paperIds, $array_intersect));
        // 需要添加的标签id
        $add_paperIds = array_diff($paperIds, $array_intersect);
        // 如果存在删除的权限角色关系
        if (!empty($delete_paperIds)) {
            // 先把关系表中需要删除的删除
            DB::delete("DELETE FROM `staff_skill_paper` WHERE `staff_id` = $staffId AND `skill_id` = $skillId AND `paper_id` IN ($delete_paperIds)");
        }
        if (!empty($add_paperIds)) {
            // 重新生成新关系
            foreach ($add_paperIds as $value) {
                DB::table('staff_skill_paper')->insert([
                    'staff_id' => $staffId,
                    'skill_id' => $skillId,
                    'paper_id' => $value,
                ]);
            }
        }

        return true;
    }

    /**
     * 逻辑删除员工
     *
     * @param int $id 员工id
     * @param int $version
     * @return void
     */
    public function deleteStaff($id, $version)
    {
        $staff = Staff::where('status', 0)->find($id);
        if (empty($staff)) {
            send_msg_json(ERROR_RETURN, "该员工不存在");
        }
        if ($staff->version != $version) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        
        $staff->status = 1;

        DB::transaction(function () use ($staff, $id){
            $staff->save();
            // 删除员工标签表
            DB::table('staff_labels')->where(['staff_id'=>$id,'status'=>0])->update(['status'=>1]);
            // 删除员工证件表,没写完
            DB::table('staff_papers')->where(['staff_id'=>$id,'status'=>0])->update(['status'=>1]);
            // 删除员工技能表及其关系表
            $this->deleteStaffSkillsByStaffId($id);
            // 最后需要删除图片            
            return true;
        });
        return true;
    }

    /**
     * 根据员工id删除所有技能
     *
     * @param int $id
     * @return boolean
     */
    private function deleteStaffSkillsByStaffId($id)
    {
        // 该员工所有技能id集合
        $staffSkillIds = DB::table('staff_skills')->select(['id'])->where(['status'=>0, 'staff_id'=>$id])->pluck('id');
        // 删除员工技能表数据
        DB::table('staff_skills')->where(['status'=>0, 'staff_id'=>$id])->update(['status'=>1]);
        // 遍历删除关系表
        foreach ($staffSkillIds as $value) {
            // 删除员工技能标签关系表
            $this->deleteStaffSkillLabel($value, $id);
            // 删除员工证书关系表
            $this->deleteStaffSkillPaper($value, $id);
        }
        return true;
    }

    /**
     * 获取技能列表
     *
     * @param array $params
     * @param integer $pageNumber
     * @return array
     */
    public function getStaffSkillList($params, $pageNumber = 15)
    {
        $list = StaffSkills::join('staff', function ($join) {
            $join->on('staff.id', '=', 'staff_skills.staff_id');
        })->select($this->staffSkillList)
        ->where(function ($query) use ($params){
            // 逻辑删除判断
            $query->where('staff_skills.status', 0);
            // 技能分类id
            if ($params['service_category_id']) {
                $query->where('service_category_id', $params['service_category_id']);
            }
        })
        ->paginate($pageNumber)
        ->toArray();

        return $list;
    }

    /**
     * 审核员工技能
     *
     * @param int $id
     * @param int $review
     * @param string $remark
     * @param int $version
     * @return int
     */
    public function reviewStaffSkill($id, $review, $remark, $version)
    {
        $staffSkill = StaffSkills::where('status', 0)->find($id);
        if (empty($staffSkill)) {
            send_msg_json(ERROR_RETURN, "该员工技能不存在");
        }
        if ($staffSkill->version != $version) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        $staffSkill->review = $review;
        $staffSkill->remark = $remark;
        $staffSkill->version = $version+1;

        $staffSkill->save();

        return $staffSkill->id;
    }

    /**
     * 逻辑删除员工技能
     *
     * @param int $id
     * @param int $version
     * @return boolean
     */
    public function deleteStaffSkill($id, $version)
    {
        $staffSkill = StaffSkills::where('status', 0)->find($id);
        if (empty($staffSkill)) {
            send_msg_json(ERROR_RETURN, "该员工技能不存在");
        }
        if ($staffSkill->version != $version) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        $staffSkill->status = 1;

        DB::transaction(function () use ($staffSkill, $id){
            $staffSkill->save();
            // 员工id
            $staffId = $staffSkill->staff_id;
            // 删除技能标签关系表
            $this->deleteStaffSkillLabel($id, $staffId);
            // 删除技能材料关系表
            $this->deleteStaffSkillPaper($id, $staffId);

            return true;
        });
        // 员工技能id
        return true;
    }

    /**
     * 删除技能标签关系表
     *
     * @param int $id
     * @param int $staffId
     * @return boolean
     */
    private function deleteStaffSkillLabel($id, $staffId)
    {
        // 物理删除关系表数据
        DB::table('staff_skill_label')->where(['skill_id'=>$id, 'staff_id'=>$staffId])->delete();

        return true;
    }

    /**
     * 删除技能材料关系表
     *
     * @param int $id
     * @param int $staffId
     * @return boolean
     */
    private function deleteStaffSkillPaper($id, $staffId)
    {
        // 物理删除
        DB::table('staff_skill_paper')->where(['skill_id'=>$id, 'staff_id'=>$staffId])->delete();

        return true;
    }
}
