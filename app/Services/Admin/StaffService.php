<?php

namespace App\Services\Admin;

use App\Entities\Staff;
use App\Entities\StaffSkills;
use App\Entities\StaffLabels;
use App\Entities\StaffPapers;
use App\Entities\StaffServiceRegions;
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
     * 获取员工列表
     *
     * @param array $params
     * @return array
     */
    public function getStaffList($params, $format = 'paginate', $pageNumber = 15)
    {
        $modelObj = Staff::select($this->staffList)
            ->where(function ($query) use ($params){
                // 逻辑删除判断
                $query->where('status', 0);
                // 如果有姓名搜索项
                if ($params['name']) {
                    $query->where('name','like','%'.$params['name'].'%');
                }
                // 根据服务类型筛选
                if (!empty($params['service_category_id'])) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_skills` WHERE `service_category_id` = ? AND `status` = 0)', [$params['service_category_id']]);
                }
                // 根据特长标签搜索
                if (!empty($params['ability_ids'])) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_labels` WHERE `ability_id` IN (?) AND `status` = 0)', [implode(",",$params['ability_ids'])]);
                }
                // 根据服务地区搜索
                if (!empty($params['region_ids'])) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_service_regions` WHERE `region_id` IN (?) AND `status` = 0)', [implode(",",$params['region_ids'])]);
                }
                // 根据证件类型查询
                if (!empty($params['paper_ids'])) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_papers` WHERE `paper_id` IN (?) AND `status` = 0)', [implode(",",$params['paper_ids'])]);
                }
            })
            ->orderBy('id', 'ASC');
        if ($format == 'paginate') {
            // 普通分页
            $list = $modelObj->paginate($pageNumber)->toArray();
        } else {
            // 设置最后一个id
            $lastId = isset($params['lastId']) ? $params['lastId'] : 0;
            // 获取数据
            $list['data'] = $modelObj->where('id','>', $lastId)->limit($pageNumber)->get()->toArray();
            // 如果不为空
            if (!empty($list['data'])) {
                // 设置新的最后id
                $lastId = end($list['data'])['id'];
            }
            // 查询是否还有数据
            $count = $modelObj->where('id','>', $lastId)->count();
            // 拼凑数据
            $list['lastId'] = $lastId;
            $list['isLast'] = $count > 0 ? true : false;
        }
            
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
        $staff = Staff::select(['id','name','sex','nation','wechat','education','phone','icon','identify','age','address','bank_card','version'])
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
        return StaffPapers::where(['staff_id'=>$id, 'status'=>0])->get();
    }

    /**
     * 根据员工id获取能力标签
     *
     * @param int $id
     * @return object
     */
    public function getLabelByStaffId($id)
    {
        return StaffLabels::where(['staff_id'=>$id, 'status'=>0])->get();
    }

    /**
     * 根据员工id获取技能集合
     *
     * @param int $id
     * @return array
     */
    public function getSkillByStaffId($id)
    {
        return StaffSkills::where(['staff_id'=>$id, 'status'=>0])->get();
    }

    /**
     * 根据员工id获取服务地址
     *
     * @param int $id
     * @return array
     */
    public function getRegionByStaffId($id)
    {
        return StaffServiceRegions::where(['staff_id'=>$id, 'status'=>0])->get();
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
        $staff->identify = $params['identify'];
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
            // 编辑员工服务地区
            $this->saveStaffServiceRegion($params['region'], $params['id'], $staffId);
            // 编辑员工能力标签
            $this->saveStaffLabel($params['label'], $params['id'], $staffId);
            // 编辑员工证件
            $this->saveStaffPaper($params['paper'], $params['id'], $staffId);
            // 编辑员工技能
            $this->saveStaffSkill($params['skill'], $params['id'], $staffId);

            return $staffId;
        });

        return array(
            'returnMsg'=>$returnMsg,
            'staffId'=>$staffId
        );
    }

    private function saveStaffServiceRegion($region, $formId, $staffId)
    {
        // 如果为添加表单
        if (empty($formId)) {
            if (!empty($region)) {
                array_walk($region, function (&$item) use ($staffId){
                    DB::table('staff_service_regions')->insert(['staff_id'=>$staffId,'region_id'=>$item['region_id'],'code'=>$item['code'],'name'=>$item['name']]);
                });
            }
        // 如果为编辑表单
        } else {
            $regionIds = array_column($region, 'id');
            // 原关系id集合
            $original_regionIds = DB::table('staff_service_regions')->select('id')->where('staff_id', $staffId)->pluck('id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($regionIds, $original_regionIds);
            // 需要删除的标签id
            $delete_regionIds = array_diff($original_regionIds, $array_intersect);
            // 逻辑删除员工标签表
            if (!empty($delete_regionIds)) {
                DB::table('staff_service_regions')->whereIn('id', $delete_regionIds)->update(['status'=>1]);
            }
            if (!empty($region)) {
                array_walk($region, function (&$item) use ($staffId, $array_intersect){
                    if (!isset($item['id'])) {
                        $item['id'] = 0;
                    }
                    // 添加
                    if (!in_array($item['id'], $array_intersect)) {
                        DB::table('staff_service_regions')->insert(['staff_id'=>$staffId,'region_id'=>$item['region_id'],'code'=>$item['code'],'name'=>$item['name']]);
                    // 更新
                    } else {
                        DB::table('staff_service_regions')->where(['id'=>$item['id'], 'status'=>0])->update(['staff_id'=>$staffId,'region_id'=>$item['region_id'],'code'=>$item['code'],'name'=>$item['name']]);
                    }
                });
            }
        }
    }

    /**
     * 编辑员工能力标签
     *
     * @param array $label
     * @param int $staffId
     * @return boolean
     */
    private function saveStaffLabel($label, $formId, $staffId)
    {
        // 如果为添加表单
        if (empty($formId)) {
            if (!empty($label)) {
                array_walk($label, function (&$item) use ($staffId){
                    DB::table('staff_labels')->insert(['staff_id'=>$staffId,'ability_id'=>$item['ability_id'],'name'=>$item['name']]);
                });
            }
        // 如果为编辑表单
        } else {
            $labelIds = array_column($label, 'id');
            // 原关系id集合
            $original_labelIds = DB::table('staff_labels')->select('id')->where('staff_id', $staffId)->pluck('id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($labelIds, $original_labelIds);
            // 需要删除的标签id
            $delete_labelIds = array_diff($original_labelIds, $array_intersect);
            // 逻辑删除员工标签表
            if (!empty($delete_labelIds)) {
                DB::table('staff_labels')->whereIn('id', $delete_labelIds)->update(['status'=>1]);
            }
            if (!empty($label)) {
                array_walk($label, function (&$item) use ($staffId, $array_intersect){
                    if (!isset($item['id'])) {
                        $item['id'] = 0;
                    }
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
    private function saveStaffPaper($paper, $staffId)
    {
        return true;
    }

    /**
     * 保存员工技能
     *
     * @param int $skill
     * @param int $formId 表单id，来判断是添加还是编辑
     * @param int $staffId
     * @return void
     */
    private function saveStaffSkill($skill, $formId, $staffId)
    {
            if (empty($formId)) {
                if (!empty($skill)) {
                    array_walk($skill, function (&$item) use ($staffId){
                        DB::table('staff_skills')->insert(['staff_id'=>$staffId,'service_category_id'=>$item['service_category_id'],'name'=>$item['name'],'level'=>$item['level'],'workable'=>$item['workable'],'review'=>0]);
                    });
                }
            } else {
                $skillIds = array_column($skill, 'id');
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
                if (!empty($skill)) {
                    // 创建和添加
                    array_walk($skill, function (&$item) use ($staffId, $array_intersect){
                        if (!isset($item['id'])) {
                            $item['id'] = 0;
                        }
                        // 添加
                        if (!in_array($item['id'], $array_intersect)) {
                            DB::table('staff_skills')->insert(['staff_id'=>$staffId,'service_category_id'=>$item['service_category_id'],'name'=>$item['name']]);
                        // 更新
                        } else {
                            Db::table('staff_skills')->where(['id'=>$item['id'], 'status'=>0])->update(['staff_id'=>$staffId,'service_category_id'=>$item['service_category_id'],'name'=>$item['name']]);
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
            DB::table('staff_service_regions')->where(['staff_id'=>$id,'status'=>0])->update(['status'=>1]);
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
