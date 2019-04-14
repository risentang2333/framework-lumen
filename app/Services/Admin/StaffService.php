<?php

namespace App\Services\Admin;

use App\Entities\Staff;
use App\Entities\StaffSkills;
use App\Entities\StaffCourses;
use App\Entities\StaffPapers;
use App\Entities\StaffPhotos;
use App\Entities\StaffRegions;
use App\Entities\StaffServiceCrowds;
use App\Entities\StaffServiceTypes;
use App\Entities\StaffCertificateImages;
use App\Entities\StaffCertificates;
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
        'id','register_at','authentication','name','age','phone','return_msg','working_status','remarks','working_age','working_experience','nation','birthplace','identify','address','education','urgent_phone','bank_card','icon','source','manager_id','manager_name','code as staff_code','sex','version','created_at','type','status'
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
                if ($params['phone']) {
                    $query->where('phone','like', '%'.$params['phone'].'%');
                }
                if ($params['staff_code']) {
                    $query->where('code','like','%'.$params['staff_code'].'%');
                }
                // 根据服务类型筛选
                if (!empty($params['service_category_id'])) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_skills` WHERE `service_category_id` = ?)', [$params['service_category_id']]);
                }
                // 根据特长标签搜索
                if (!empty($params['service_crowd_ids'])) {
                    $query->whereRaw('`id` in (SELECT `staff_id` FROM `staff_service_crowds` WHERE `service_crowd_id` IN (?))', [implode(",",$params['service_crowd_ids'])]);
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
        $staff = Staff::select(['id','register_at','authentication','name','age','phone','return_msg','working_status','remarks','working_age','working_experience','nation','birthplace','identify','address','education','urgent_phone','bank_card','icon','source','manager_id','manager_name','code as staff_code','sex','version','created_at','type','status'])
                      ->where('id',$id)
                      ->first();
        if (empty($staff)) {
            send_msg_json(ERROR_RETURN, "该服务人员不存在");
        }
        // js和php时间戳差了1000
        $staff->register_at = $staff->register_at * 1000;
        $staff->created_at = $staff->created_at * 1000;

        return $staff->toArray();
    }

    public function getCourseById($id)
    {
        return StaffCourses::select(['id','course_id','name'])->where('staff_id',$id)->get()->toArray();
    }

    /**
     * 根据员工id获取证书
     *
     * @param int $id
     * @return object
     */
    public function getPaperById($id)
    {
        // 证书标签
        return StaffPapers::select(['id','paper_category_id','name'])->where('staff_id',$id)->get()->toArray();
    }

    public function getPhotoById($id)
    {
        // 证书标签
        return StaffPhotos::select(['id','url as path','name'])->where('staff_id',$id)->get()->toArray();
    }

    /**
     * 根据员工id获取服务地址
     *
     * @param int $id
     * @return array
     */
    public function getRegionById($id)
    {
        return StaffRegions::select(['id','region_id','name'])->where('staff_id', $id)->get()->toArray();
    }

    public function getServiceCrowdsById($id)
    {
        return StaffServiceCrowds::select(['id','service_crowd_id','name'])->where('staff_id', $id)->get()->toArray();
    }

    public function getServiceTypesById($id)
    {
        return StaffServiceTypes::select(['id','service_type_id','name'])->where('staff_id', $id)->get()->toArray();
    }

    /**
     * 根据员工id获取技能集合
     *
     * @param int $id
     * @return array
     */
    public function getSkillById($id)
    {
        return StaffSkills::select(['id','service_category_id','name'])->where('staff_id', $id)->get();
    }

    public function getCertificateById($id)
    {
        $certificate = StaffCertificates::select(['id','paper_category_id','name as paper_category_name'])->where('staff_id',$id)->get()->toArray();
        if (!empty($certificate)) {
            array_walk($certificate, function (&$item) {
                $item['images'] = DB::table('staff_certificate_images')->select(['id','name','url as path'])->where('staff_certificate_id',$item['id'])->get()->toArray();
            });
        }
        return $certificate;
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
        $staff->working_age = $params['working_age'];
        $staff->working_experience = $params['working_experience'];
        $staff->nation = $params['nation'];
        $staff->birthplace = $params['birthplace'];
        $staff->identify = $params['identify'];
        $staff->address = $params['address'];
        $staff->education = $params['education'];
        $staff->urgent_phone = $params['urgent_phone'];
        $staff->bank_card = $params['bank_card'];
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
            $this->saveStaffCourse($params['course'], $params['id'], $staffId);
            // 编辑员工证件
            $this->saveStaffPaper($params['paper'], $params['id'], $staffId);
            $this->saveStaffPhoto($params['photo'], $params['id'], $staffId);
            // 编辑员工服务地区
            $this->saveStaffRegion($params['region'], $params['id'], $staffId);
            // 编辑员工能力标签
            $this->saveStaffServiceCrowd($params['service_crowd'], $params['id'], $staffId);

            $this->saveStaffServiceType($params['service_type'], $params['id'], $staffId);
            // 编辑员工技能
            $this->saveStaffSkill($params['skill'], $params['id'], $staffId);

            $this->saveStaffCertificates($params['certificate'], $params['id'], $staffId);

            return $staffId;
        });

        return array(
            'returnMsg'=>$returnMsg,
            'staffId'=>$staffId
        );
    }

    private function saveStaffCourse($course, $formId, $staffId)
    {
        // 如果为添加表单
        if (empty($formId)) {
            if (!empty($course)) {
                array_walk($course, function (&$item) use ($staffId){
                    DB::table('staff_courses')->insert(['staff_id'=>$staffId,'course_id'=>$item['course_id'],'name'=>$item['name']]);
                });
            }
        // 如果为编辑表单
        } else {
            $courseIds = array_column($course, 'id');
            // 原关系id集合
            $original_courseIds = DB::table('staff_courses')->select('id')->where('staff_id', $staffId)->pluck('id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($courseIds, $original_courseIds);
            // 需要删除的标签id
            $delete_courseIds = array_diff($original_courseIds, $array_intersect);
            // 物理删除员工标签表
            if (!empty($delete_courseIds)) {
                DB::table('staff_courses')->whereIn('id', $delete_courseIds)->delete();
            }
            if (!empty($course)) {
                array_walk($course, function (&$item) use ($staffId, $array_intersect){
                    if (!isset($item['id'])) {
                        $item['id'] = 0;
                    }
                    // 添加
                    if (!in_array($item['id'], $array_intersect)) {
                        DB::table('staff_courses')->insert(['staff_id'=>$staffId,'course_id'=>$item['course_id'],'name'=>$item['name']]);
                    // 更新
                    } else {
                        DB::table('staff_courses')->where('id', $item['id'])->update(['staff_id'=>$staffId,'course_id'=>$item['course_id'],'name'=>$item['name']]);
                    }
                });
            }
        }

        return true;
    }

    private function saveStaffPaper($paper, $formId, $staffId)
    {
        // 如果为添加表单
        if (empty($formId)) {
            if (!empty($paper)) {
                array_walk($paper, function (&$item) use ($staffId){
                    DB::table('staff_papers')->insert(['staff_id'=>$staffId,'paper_category_id'=>$item['paper_category_id'],'name'=>$item['name']]);
                });
            }
        // 如果为编辑表单
        } else {
            $paperIds = array_column($paper, 'id');
            // 原关系id集合
            $original_paperIds = DB::table('staff_papers')->select('id')->where('staff_id', $staffId)->pluck('id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($paperIds, $original_paperIds);
            // 需要删除的标签id
            $delete_paperIds = array_diff($original_paperIds, $array_intersect);
            // 物理删除员工标签表
            if (!empty($delete_paperIds)) {
                DB::table('staff_papers')->whereIn('id', $delete_paperIds)->delete();
            }
            if (!empty($paper)) {
                array_walk($paper, function (&$item) use ($staffId, $array_intersect){
                    if (!isset($item['id'])) {
                        $item['id'] = 0;
                    }
                    // 添加
                    if (!in_array($item['id'], $array_intersect)) {
                        DB::table('staff_papers')->insert(['staff_id'=>$staffId,'paper_category_id'=>$item['paper_category_id'],'name'=>$item['name']]);
                    // 更新
                    } else {
                        DB::table('staff_papers')->where('id', $item['id'])->update(['staff_id'=>$staffId,'paper_category_id'=>$item['paper_category_id'],'name'=>$item['name']]);
                    }
                });
            }
        }
        return true;
    }

    private function saveStaffPhoto($photo, $formId, $staffId)
    {
        // 如果为添加表单
        if (empty($formId)) {
            if (!empty($photo)) {
                array_walk($photo, function (&$item) use ($staffId){
                    // 移动图片
                    $url = move_upload_file($item['path'], 'paper');
                    // 更新数据库
                    DB::table('staff_photos')->insert(['staff_id'=>$staffId,'name'=>$item['name'],'url'=> $url]);
                });
            }
        // 如果为编辑表单
        } else {
            $photoIds = array_column($photo, 'id');
            // 原关系id集合
            $original_photoIds = DB::table('staff_photos')->select('id')->where('staff_id', $staffId)->pluck('id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($photoIds, $original_photoIds);
            // 需要删除的标签id
            $delete_photoIds = array_diff($original_photoIds, $array_intersect);
            // 物理删除员工标签表
            if (!empty($delete_photoIds)) {
                // 获取要删除的地址
                $delete_url = DB::table('staff_photos')->select('url')->whereIn('id', $delete_photoIds)->pluck('url')->toArray();
                // 逻辑删除员工标签表
                DB::table('staff_photos')->whereIn('id', $delete_photoIds)->delete();
                // 删除图片
                array_walk($delete_url, function ($item) {
                    if (file_exists(config('config.disks.resource.root') . '/' .$item) && $item != '') {
                        unlink(config('config.disks.resource.root') . '/' .$item);
                    }
                });
            }
            if (!empty($photo)) {
                // 添加
                array_walk($photo, function (&$item) use ($staffId, $array_intersect){
                    if (!isset($item['id'])) {
                        $item['id'] = 0;
                    }
                    // 添加
                    if (!in_array($item['id'], $array_intersect)) {
                        // 移动图片到指定位置
                        $url = move_upload_file($item['path'], 'paper');

                        DB::table('staff_photos')->insert(['staff_id'=>$staffId,'name'=>$item['name'],'url'=> $url]);
                    }
                });
            }
        }
        return true;
    }

    private function saveStaffRegion($region, $formId, $staffId)
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

        return true;
    }

    /**
     * 编辑员工能力标签
     *
     * @param array $crowd
     * @param int $staffId
     * @return boolean
     */
    private function saveStaffServiceCrowd($crowd, $formId, $staffId)
    {
        // 如果为添加表单
        if (empty($formId)) {
            if (!empty($crowd)) {
                array_walk($crowd, function (&$item) use ($staffId){
                    DB::table('staff_service_crowds')->insert(['staff_id'=>$staffId,'service_crowd_id'=>$item['service_crowd_id'],'name'=>$item['name']]);
                });
            }
        // 如果为编辑表单
        } else {
            $crowdIds = array_column($crowd, 'id');
            // 原关系id集合
            $original_crowdIds = DB::table('staff_service_crowds')->select('id')->where('staff_id', $staffId)->pluck('id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($crowdIds, $original_crowdIds);
            // 需要删除的标签id
            $delete_crowdIds = array_diff($original_crowdIds, $array_intersect);
            // 物理删除员工标签表
            if (!empty($delete_crowdIds)) {
                DB::table('staff_service_crowds')->whereIn('id', $delete_crowdIds)->delete();
            }
            if (!empty($crowd)) {
                array_walk($crowd, function (&$item) use ($staffId, $array_intersect){
                    if (!isset($item['id'])) {
                        $item['id'] = 0;
                    }
                    // 添加
                    if (!in_array($item['id'], $array_intersect)) {
                        DB::table('staff_service_crowds')->insert(['staff_id'=>$staffId,'service_crowd_id'=>$item['service_crowd_id'],'name'=>$item['name']]);
                    // 更新
                    } else {
                        DB::table('staff_service_crowds')->where('id', $item['id'])->update(['staff_id'=>$staffId,'service_crowd_id'=>$item['service_crowd_id'],'name'=>$item['name']]);
                    }
                });
            }
        }
        
        return true;
    }

    private function saveStaffServiceType($type, $formId, $staffId)
    {
        // 如果为添加表单
        if (empty($formId)) {
            if (!empty($type)) {
                array_walk($type, function (&$item) use ($staffId){
                    DB::table('staff_service_types')->insert(['staff_id'=>$staffId,'service_type_id'=>$item['service_type_id'],'name'=>$item['name']]);
                });
            }
        // 如果为编辑表单
        } else {
            $typeIds = array_column($type, 'id');
            // 原关系id集合
            $original_typeIds = DB::table('staff_service_types')->select('id')->where('staff_id', $staffId)->pluck('id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($typeIds, $original_typeIds);
            // 需要删除的标签id
            $delete_typeIds = array_diff($original_typeIds, $array_intersect);
            // 物理删除员工标签表
            if (!empty($delete_typeIds)) {
                DB::table('staff_service_types')->whereIn('id', $delete_typeIds)->delete();
            }
            if (!empty($type)) {
                array_walk($type, function (&$item) use ($staffId, $array_intersect){
                    if (!isset($item['id'])) {
                        $item['id'] = 0;
                    }
                    // 添加
                    if (!in_array($item['id'], $array_intersect)) {
                        DB::table('staff_service_types')->insert(['staff_id'=>$staffId,'service_type_id'=>$item['service_type_id'],'name'=>$item['name']]);
                    // 更新
                    } else {
                        DB::table('staff_service_types')->where('id', $item['id'])->update(['staff_id'=>$staffId,'service_type_id'=>$item['service_type_id'],'name'=>$item['name']]);
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
     * 保存员工证件
     *
     * @param array $papers
     * @param int $staffId
     * @return boolean
     */
    private function saveStaffCertificates($certificate, $formId, $staffId)
    {
        if (empty($formId)) {
            if (!empty($certificate)) {
                array_walk($certificate, function (&$item) use ($staffId, $formId){
                    // 插入照片标签表
                    DB::table('staff_certificates')->insert(['staff_id'=>$staffId,'paper_category_id'=>$item['paper_category_id'],'name'=>$item['paper_category_name']]);
                    // 获得插入id
                    $insertId = DB::getPdo()->lastInsertId();

                    $this->saveImage($item['images'], $formId, $insertId);
                });
            }
        } else {
            $certificateIds = array_column($certificate, 'paper_category_id');
            // 原关系id集合
            $original_certificateIds = DB::table('staff_certificates')->select('paper_category_id')->where('staff_id', $staffId)->groupBy('paper_category_id')->pluck('paper_category_id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($certificateIds, $original_certificateIds);
            // 需要删除的标签id
            $delete_certificateIds = array_diff($original_certificateIds, $array_intersect);
            
            if (!empty($delete_certificateIds)) {
                
                // 获取要删除的图片id
                $delete_staff_certificate_id = DB::table('staff_certificates')->select('id')->whereIn('paper_category_id', $delete_certificateIds)->where('staff_id',$staffId)->pluck('id')->toArray();
                // 获取要删除的地址
                $delete_url = DB::table('staff_certificate_images')->select('url')->whereIn('staff_certificate_id', $delete_staff_certificate_id)->pluck('url')->toArray();
                // 逻辑删除员工证书表
                DB::table('staff_certificates')->whereIn('id',$delete_staff_certificate_id)->delete();
                // 删除images表
                DB::table('staff_certificate_images')->whereIn('staff_certificate_id', $delete_staff_certificate_id)->delete();
                // 删除图片
                array_walk($delete_url, function ($item) {
                    if (file_exists(config('config.disks.resource.root') . '/' .$item) && $item != '') {
                        unlink(config('config.disks.resource.root') . '/' .$item);
                    }
                });
            }
            if (!empty($certificate)) {
                array_walk($certificate, function (&$item) use ($staffId, $formId){
                    if (!isset($item['id'])) {
                        // 插入照片标签表
                        DB::table('staff_certificates')->insert(['staff_id'=>$staffId,'paper_category_id'=>$item['paper_category_id'],'name'=>$item['paper_category_name']]);
                        // 获得插入id
                        $insertId = DB::getPdo()->lastInsertId();
                        // 执行一遍保存图片
                        $this->saveImage($item['images'], $formId, $insertId);
                    } else {
                        $insertId = DB::table('staff_certificates')->select('id')->where(['staff_id'=>$staffId,'paper_category_id'=>$item['paper_category_id']])->first()->id;
                        // 执行一遍保存图片
                        $this->saveImage($item['images'], $formId, $insertId);
                    }
                });
            }
        }
        return true;
    }

    private function saveImage($images, $formId, $insertId)
    {
        if (empty($formId)) {
            if (!empty($images)) {
                array_walk($images, function (&$item) use ($insertId){
                    // 移动图片
                    $url = move_upload_file($item['path'], 'certificate');
                    // 更新数据库
                    DB::table('staff_certificate_images')->insert(['staff_certificate_id'=>$insertId,'name'=>$item['name'],'url'=> $url]);
                });
            }
        } else {
            $imageIds = array_column($images, 'id');
            // 原关系id集合
            $original_imageIds = DB::table('staff_certificate_images')->select('id')->where('staff_certificate_id',$insertId)->pluck('id')->toArray();
            // 原关系数组与新数组交集
            $array_intersect = array_intersect($imageIds, $original_imageIds);
            // 需要删除的标签id
            $delete_imageIds = array_diff($original_imageIds, $array_intersect);
            if (!empty($delete_imageIds)) {
                // 获取要删除的地址
                $delete_url = DB::table('staff_certificate_images')->select('url')->whereIn('id', $delete_imageIds)->pluck('url')->toArray();
                // 逻辑删除员工标签表
                DB::table('staff_certificate_images')->whereIn('id', $delete_imageIds)->delete();
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
                        $url = move_upload_file($item['path'], 'certificate');

                        DB::table('staff_certificate_images')->insert(['staff_certificate_id'=>$insertId,'name'=>$item['name'],'url'=> $url]);
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

    public function checkStaffName($id, $name)
    {
        $names = Staff::select(['id','name'])->where('id','!=',$id)->where('name','like',$name.'%')->get()->toArray();
        
        if (!empty($names)) {
            $data['isRepeat'] = 1;
            $data['count'] = count($names);
            $data['names'] = $names;
        } else {
            $data['isRepeat'] = 0;
            $data['count'] = 0;
            $data['names'] = [];
        }
        return $data;
    }
}
