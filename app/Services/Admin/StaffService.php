<?php

namespace App\Services\Admin;

use App\Entities\Staff;
use App\Entities\StaffSkills;
use App\Entities\StaffLabels;
use App\Entities\StaffPapers;
use App\Entities\StaffPaperImages;
use App\Entities\StaffRegions;
use App\Entities\Managers;
use Illuminate\Support\Facades\DB;

class StaffService 
{
    /**
     * 员工列表查询字段
     *
     * @var array
     */
    private $staffList = [
        'id','register_at','authentication','name','age','phone','return_msg','working_status','remarks','service_type','working_age','working_experience','nation','birthplace','identify','address','education','urgent_phone','bank_card','icon','course','source','manager_id','manager_name','code as staff_code','sex','version','created_at','type','status'
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
                // 如果服务人员列表是为了订单匹配，则不显示停用的人
                if ($params['get_for'] == 'order') {
                    $query->where('status', 0);
                }
                // 如果有姓名搜索项
                if ($params['name']) {
                    $query->where('name','like','%'.$params['name'].'%');
                }
                if ($params['staff_code']) {
                    $query->where('code','like','%'.$params['staff_code'].'%');
                }
                // 根据服务类型筛选
                if (!empty($params['service_category_id'])) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_skills` WHERE `service_category_id` = ?)', [$params['service_category_id']]);
                }
                // 根据特长标签搜索
                if (!empty($params['ability_ids'])) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_labels` WHERE `service_crowd_id` IN (?))', [implode(",",$params['ability_ids'])]);
                }
                // 根据服务地区搜索
                if (!empty($params['region_ids'])) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_regions` WHERE `region_id` IN (?))', [implode(",",$params['region_ids'])]);
                }
                // 根据证件类型查询
                if (!empty($params['paper_ids'])) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_papers` WHERE `paper_category_id` IN (?))', [implode(",",$params['paper_ids'])]);
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
     * 通过accessToken获取管理员信息
     *
     * @param [type] $accessToken
     * @return array
     */
    private function getManagerByToken($accessToken)
    {
        $manager = Managers::select('id as manager_id', 'name as manager_name')->where('access_token', $accessToken)->first();

        if (empty($manager)) {
            send_msg_json(ERROR_RETURN, "该管理员不存在");
        }

        return $manager->toArray();
    }

    /**
     * 根据服务人员id查询服务人员信息
     *
     * @param  $id
     * @return void
     */
    public function getStaffById($id)
    {
        $staff = Staff::select(['id','register_at','authentication','name','age','phone','return_msg','working_status','remarks','service_type','working_age','working_experience','nation','birthplace','identify','address','education','urgent_phone','bank_card','icon','course','source','manager_id','manager_name','code as staff_code','sex','version','created_at','type','status'])
                      ->where('id',$id)
                      ->first();
        if (empty($staff)) {
            send_msg_json(ERROR_RETURN, "该服务人员不存在");
        }
        // js和php时间戳差了1000
        $staff->register_at = $staff->register_at * 1000;
        $staff->created_at = $staff->created_at * 1000;

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
        // 证书标签
        $papers = StaffPapers::select(['id','paper_category_id','paper_category_name'])->where('staff_id',$id)->get()->toArray();
        if (!empty($papers)) {
            array_walk($papers, function (&$item){
                $item['images'] = StaffPaperImages::select(['id','staff_paper_id','name','url as path'])->where('staff_paper_id',$item['id'])->get()->toArray();
            });
        }
        return $papers;
    }

    /**
     * 根据员工id获取能力标签
     *
     * @param int $id
     * @return object
     */
    public function getLabelByStaffId($id)
    {
        return StaffLabels::where('staff_id', $id)->get();
    }

    /**
     * 根据员工id获取技能集合
     *
     * @param int $id
     * @return array
     */
    public function getSkillByStaffId($id)
    {
        return StaffSkills::where('staff_id', $id)->get();
    }

    /**
     * 根据员工id获取服务地址
     *
     * @param int $id
     * @return array
     */
    public function getRegionByStaffId($id)
    {
        return StaffRegions::where('staff_id', $id)->get();
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
            ->where('phone', $phone)->first();
        
        return $staff;
    }

    /**
     * 保存服务人员
     *
     * @param array $params
     * @return string
     */
    public function saveStaff($params, $accessToken)
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
            $staff = Staff::find($params['id']);
            if (empty($staff)) {
                send_msg_json(ERROR_RETURN, "该服务人员不存在");
            }
            if ($staff->version != $params['version']) {
                send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
            }
            $staff->version = $params['version']+1;
            $returnMsg = '编辑成功';
        }
        $staff->register_at = $params['register_at']/1000;
        $staff->authentication = $params['authentication'];
        $staff->name = $params['name'];
        $staff->age = $params['age'];
        $staff->phone = $params['phone'];
        $staff->return_msg = $params['return_msg'];
        $staff->working_status = $params['working_status'];
        $staff->remarks = $params['remarks'];
        $staff->service_type = $params['service_type'];
        $staff->working_age = $params['working_age'];
        $staff->working_experience = $params['working_experience'];
        $staff->nation = $params['nation'];
        $staff->birthplace = $params['birthplace'];
        $staff->identify = $params['identify'];
        $staff->address = $params['address'];
        $staff->education = $params['education'];
        $staff->urgent_phone = $params['urgent_phone'];
        $staff->bank_card = $params['bank_card'];
        $staff->course = $params['course'];
        $staff->source = $params['source'];
        $staff->sex = $params['sex'];
        $staff->education = $params['education'];
        // 根据token获取管理员姓名
        $manager = $this->getManagerByToken($accessToken);
        $staff->manager_id = $manager['manager_id'];
        $staff->manager_name = $manager['manager_name'];
        // 保存并获取操作id
        $staffId = DB::transaction(function () use ($staff, $params){
            // 先移动图片，在更新数据库
            if ($params['icon'] != '') {
                $url = move_upload_file($params['icon'], 'icon');
                $staff->icon = $url;
            }
            $staff->save();
            // 如果为创建添加员工号
            if (empty($params['id'])) {
                // 根据订单id设置订单号
                $code = sprintf("%05d", $staff->id);
                $staff->code = $code;
                $staff->save();
            }
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
                    DB::table('staff_regions')->insert(['staff_id'=>$staffId,'region_id'=>$item['region_id'],'name'=>$item['name']]);
                });
            }
        // 如果为编辑表单
        } else {
            $regionIds = array_column($region, 'id');
            // 原关系id集合
            $original_regionIds = DB::table('staff_regions')->select('id')->where('staff_id', $staffId)->pluck('id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($regionIds, $original_regionIds);
            // 需要删除的标签id
            $delete_regionIds = array_diff($original_regionIds, $array_intersect);
            // 物理删除员工标签表
            if (!empty($delete_regionIds)) {
                DB::table('staff_regions')->whereIn('id', $delete_regionIds)->delete();
            }
            if (!empty($region)) {
                array_walk($region, function (&$item) use ($staffId, $array_intersect){
                    if (!isset($item['id'])) {
                        $item['id'] = 0;
                    }
                    // 添加
                    if (!in_array($item['id'], $array_intersect)) {
                        DB::table('staff_regions')->insert(['staff_id'=>$staffId,'region_id'=>$item['region_id'],'name'=>$item['name']]);
                    // 更新
                    } else {
                        DB::table('staff_regions')->where('id', $item['id'])->update(['staff_id'=>$staffId,'region_id'=>$item['region_id'],'name'=>$item['name']]);
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
                    DB::table('staff_labels')->insert(['staff_id'=>$staffId,'service_crowd_id'=>$item['service_crowd_id'],'name'=>$item['name']]);
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
            // 物理删除员工标签表
            if (!empty($delete_labelIds)) {
                DB::table('staff_labels')->whereIn('id', $delete_labelIds)->delete();
            }
            if (!empty($label)) {
                array_walk($label, function (&$item) use ($staffId, $array_intersect){
                    if (!isset($item['id'])) {
                        $item['id'] = 0;
                    }
                    // 添加
                    if (!in_array($item['id'], $array_intersect)) {
                        DB::table('staff_labels')->insert(['staff_id'=>$staffId,'service_crowd_id'=>$item['service_crowd_id'],'name'=>$item['name']]);
                    // 更新
                    } else {
                        DB::table('staff_labels')->where('id', $item['id'])->update(['staff_id'=>$staffId,'service_crowd_id'=>$item['service_crowd_id'],'name'=>$item['name']]);
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
    private function saveStaffPaper($paper, $formId, $staffId)
    {
        if (empty($formId)) {
            if (!empty($paper)) {
                array_walk($paper, function (&$item) use ($staffId, $formId){
                    // 插入照片标签表
                    DB::table('staff_papers')->insert(['staff_id'=>$staffId,'paper_category_id'=>$item['paper_category_id'],'paper_category_name'=>$item['paper_category_name']]);
                    // 获得插入id
                    $insertId = DB::getPdo()->lastInsertId();

                    $this->savePaper($item['images'], $formId, $insertId);
                });
            }
        } else {
            $paperIds = array_column($paper, 'paper_category_id');
            // 原关系id集合
            $original_paperIds = DB::table('staff_papers')->select('paper_category_id')->where('staff_id', $staffId)->groupBy('paper_category_id')->pluck('paper_category_id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($paperIds, $original_paperIds);
            // 需要删除的标签id
            $delete_paperIds = array_diff($original_paperIds, $array_intersect);
            
            if (!empty($delete_paperIds)) {
                
                // 获取要删除的图片id
                $delete_staff_paper_id = DB::table('staff_papers')->select('id')->whereIn('paper_category_id', $delete_paperIds)->where('staff_id',$staffId)->pluck('id');
                // 获取要删除的地址
                $delete_url = DB::table('staff_paper_images')->select('url')->whereIn('staff_paper_id', $delete_staff_paper_id)->pluck('url')->toArray();
                // 逻辑删除员工证书表
                DB::table('staff_papers')->whereIn('id',$delete_staff_paper_id)->delete();
                // 删除images表
                DB::table('staff_paper_images')->whereIn('staff_paper_id', $delete_staff_paper_id)->delete();
                // 删除图片
                array_walk($delete_url, function ($item) {
                    if (file_exists(config('config.disks.resource.root') . '/' .$item) && $item != '') {
                        unlink(config('config.disks.resource.root') . '/' .$item);
                    }
                });
            }
            array_walk($paper, function (&$item) use ($staffId, $formId, $array_intersect){
                if (!isset($item['paper_category_id'])) {
                    // 插入照片标签表
                    DB::table('staff_papers')->insert(['staff_id'=>$staffId,'paper_category_id'=>$item['paper_category_id'],'paper_category_name'=>$item['paper_category_name']]);
                    // 获得插入id
                    $insertId = DB::getPdo()->lastInsertId();
                    // 执行一遍保存图片
                    $this->savePaper($item['images'], $formId, $insertId);
                } else {
                    $insertId = DB::table('staff_papers')->select('id')->where(['staff_id'=>$staffId,'paper_category_id'=>$item['paper_category_id']])->first()->id;
                    // 执行一遍保存图片
                    $this->savePaper($item['images'], $formId, $insertId);
                }
            });
        }
        return true;
    }

    private function savePaper($images, $formId, $insertId)
    {
        if (empty($formId)) {
            if (!empty($images)) {
                array_walk($images, function (&$item) use ($insertId){
                    // 移动图片
                    $url = move_upload_file($item['path'], 'paper');
                    // 更新数据库
                    DB::table('staff_paper_images')->insert(['staff_paper_id'=>$insertId,'name'=>$item['name'],'url'=> $url]);
                });
            }
        } else {
            $imageIds = array_column($images, 'id');
            // 原关系id集合
            $original_imageIds = DB::table('staff_paper_images')->select('id')->where('staff_paper_id',$insertId)->pluck('id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($imageIds, $original_imageIds);
            // 需要删除的标签id
            $delete_imageIds = array_diff($original_imageIds, $array_intersect);
            if (!empty($delete_imageIds)) {
                // 获取要删除的地址
                $delete_url = DB::table('staff_paper_images')->select('url')->whereIn('id', $delete_imageIds)->pluck('url')->toArray();
                // 逻辑删除员工标签表
                DB::table('staff_paper_images')->whereIn('id', $delete_imageIds)->delete();
                // 删除图片
                array_walk($delete_url, function ($item) {
                    if (file_exists(config('config.disks.resource.root') . '/' .$item) && $item != '') {
                        unlink(config('config.disks.resource.root') . '/' .$item);
                    }
                });
            }
            if (!empty($images)) {
                // 创建和添加
                array_walk($images, function (&$item) use ($insertId, $array_intersect){
                    if (!isset($item['id'])) {
                        $item['id'] = 0;
                    }
                    // 添加
                    if (!in_array($item['id'], $array_intersect)) {
                        // 移动图片到指定位置
                        $url = move_upload_file($item['path'], 'paper');

                        DB::table('staff_paper_images')->insert(['staff_paper_id'=>$insertId,'name'=>$item['name'],'url'=> $url]);
                    }
                });
            }
        }
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
                    DB::table('staff_skills')->insert(['staff_id'=>$staffId,'service_category_id'=>$item['service_category_id'],'name'=>$item['name']]);
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
                DB::table('staff_skills')->whereIn('id', $delete_skillIds)->delete();
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
                        Db::table('staff_skills')->where('id', $item['id'])->update(['staff_id'=>$staffId,'service_category_id'=>$item['service_category_id'],'name'=>$item['name']]);
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
    public function changeStaffStatus($id, $version,$accessToken)
    {
        $staff = Staff::find($id);
        if (empty($staff)) {
            send_msg_json(ERROR_RETURN, "该员工不存在");
        }
        if ($staff->version != $version) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        $returnMsg = '';
        $log = '';
        // 如果启用则停用
        if ($staff->status == 0) {
            $staff->status = 1;
            $returnMsg = '停用成功';
            $log = '停用服务人员，操作id为：'.$id;
        // 如果停用则启用
        } elseif ($staff->status == 1) {
            $staff->status = 0;
            $returnMsg = '启用成功';
            $log = '启用服务人员，操作id为：'.$id;
        }
        $staff->version = $version+1;
        // 更新
        $staff->save();
        // 写入日志
        write_log($accessToken, $log);

        return $returnMsg;
    }
}
