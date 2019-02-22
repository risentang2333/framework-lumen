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
                if ($params['service_category_id']) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_skills` WHERE `service_category_id` = ?) AND `status` = 0', [$params['service_category_id']]);
                }
                // 根据特长标签搜索
                if ($params['ability_ids']) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_labels` WHERE `ability_id` IN (?) AND `status` = 0', [implode(",",$params['ability_ids'])]);
                }
                if ($params['ability_ids']) {
                    # code...
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
        $staff->sex = $params['sex'];
        $staff->nation = $params['nation'];
        $staff->wechat = $params['wechat'];
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
        if (!empty($labels)) {
            // 如果为添加表单
            if (empty($formId)) {
                array_walk($labels, function (&$item) use ($staffId){
                    DB::table('staff_labels')->insert(['staff_id'=>$staffId,'ability_id'=>$item['ability_id'],'name'=>$item['name']]);
                });
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
                    DB::table('staff_labels')->whereIn('id', $delete_labelIds)->update(['status'=>1]);
                }

                array_walk($labels, function (&$item) use ($staffId, $array_intersect){
                    // 添加
                    if (!in_array($item['id'], $array_intersect)) {
                        DB::table('staff_labels')->insert(['staff_id'=>$staffId,'ability_id'=>$item['ability_id'],'name'=>$item['name']]);
                    // 更新
                    } else {
                        DB::table('staff_labels')->where(['id'=>$item['id'], 'status'=>0])->update(['staff_id'=>$staffId,'ability_id'=>$item['ability_id'],'name'=>$item['name']]);
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
        if (!empty($skills)) {
            if (empty($formId)) {
                array_walk($skills, function (&$item) use ($staffId){
                    DB::table('staff_skills')->insert(['staff_id'=>$staffId,'service_category_id'=>$item['service_category_id'],'name'=>$item['name'],'level'=>$item['level'],'workable'=>$item['workable'],'review'=>0]);
                });
            } else {
                $skillIds = array_column($skills, 'id');
                // 原关系id集合
                $original_skillIds = DB::table('staff_skills')->select('id')->where('staff_id', $staffId)->pluck('id')->toArray();
                // 原关系数组与新数组交集
                $array_intersect = array_intersect($skillIds, $original_skillIds);
                // 需要删除的标签id
                $delete_skillIds = array_diff($original_skillIds, $array_intersect);
                if (!empty($delete_skillIds)) {
                    // 逻辑删除员工标签表
                    DB::table('staff_skills')->whereIn('id', $delete_skillIds)->update(['status'=>1]);
                }
                // 创建和添加
                array_walk($skills, function (&$item) use ($staffId, $array_intersect){
                    // 添加
                    if (!in_array($item['id'], $array_intersect)) {
                        DB::table('staff_skills')->insert(['staff_id'=>$staffId,'service_category_id'=>$item['service_category_id'],'name'=>$item['name'],'level'=>$item['level'],'workable'=>$item['workable'],'review'=>0]);
                    // 更新
                    } else {
                        Db::table('staff_skills')->where(['id'=>$item['id'], 'status'=>0])->update(['staff_id'=>$staffId,'service_category_id'=>$item['service_category_id'],'name'=>$item['name'],'level'=>$item['level'],'workable'=>$item['workable']]);
                    }
                });
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
            // 删除员工技能表
            DB::table('staff_skills')->where(['staff_id'=>$id,'status'=>0])->update(['status'=>1]);
            // 最后需要删除图片            
            return true;
        });
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

        $staffSkill->version = $version+1;

        return $staffSkill->save();
    }
}
