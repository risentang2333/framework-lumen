<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\StaffService;

class StaffController extends Controller
{
    /**
     * 获取工作人员列表
     *
     * @param Request $request
     * @return string
     */
    public function getStaffList(Request $request)
    {
        $staffService = new StaffService;
        // 服务人员姓名
        $params['name'] = trim($request->input('name',''));
        // 服务分类id
        $params['service_category_id'] = (int)trim($request->input('service_category_id', 0));
        // 能力标签id集合
        $params['ability_ids'] = $request->input('ability_ids', array());
        // 服务地址id集合
        $params['region_ids'] = $request->input('region_ids', array());
        // 根据证件类型查询
        $params['paper_ids'] = $request->input('paper_ids', array());
        // 懒加载分页用
        if ($request->input('lastId')) {
            $params['lastId'] = (int)trim($request->input('lastId', 0));
        }
        // 返回格式，lazyLoad懒加载，paginate列表分页
        $format = trim($request->input('format', 'paginate'));
        // 一页几条，默认15条
        $pageNumber = (int)trim($request->input('pageNumber', 15));

        $list = $staffService->getStaffList($params, $format, $pageNumber);

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }

    /**
     * 获取服务人员信息
     *
     * @param Request $request
     * @return string
     */
    public function getStaff(Request $request)
    {
        $staffService = new StaffService;
        // 工作人员id
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入服务人员id");
        }
        // 工作人员信息
        $staff = $staffService->getStaffById($id)->toArray();
        // 证书
        $paper = $staffService->getPaperByStaffId($id)->toArray();
        $new_paper = array();
        // 构造新的数据格式
        foreach ($paper as $v) {
            $temp = new \stdClass();
            $images = array();
            $temp->paper_category_id = $v[0]['paper_category_id'];
            $temp->paper_category_name = $v[0]['paper_category_name'];
            // 拼写images
            foreach ($v as $vv) {
                $image_temp = new \stdClass();
                $image_temp->id = $vv['id'];
                $image_temp->name = $vv['name'];
                $image_temp->url = $vv['url'];
                array_push($images, $image_temp);
            }
            $temp->images = $images;

            array_push($new_paper, $temp);
        }
        // 能力
        $label = $staffService->getLabelByStaffId($id)->toArray();
        // 技能标签材料证明集合
        $skill = $staffService->getSkillByStaffId($id)->toArray();
        // 服务地区
        $region = $staffService->getRegionByStaffId($id)->toArray();

        $staff['paper'] = $new_paper;
        $staff['label'] = $label;
        $staff['skill'] = $skill;
        $staff['region'] = $region;
        
        return send_msg_json(SUCCESS_RETURN, "success", $staff);
    }

    /**
     * 编辑/添加服务人员
     *
     * @param Request $request
     * @return string
     */
    public function editStaff(Request $request)
    {
        $staffService = new StaffService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken',''));
        // 服务人员id
        $params['id'] = (int)trim($request->input('id', 0));
        // 服务人员姓名
        $params['name'] = trim($request->input('name', ''));
        // 身份证号
        $params['identify'] = trim($request->input('identify', ''));
        // 服务人员性别
        $params['sex'] = (int)trim($request->input('sex', 1));
        // 民族
        $params['nation'] = trim($request->input('nation', ''));
        // 服务人员手机号
        $params['phone'] = trim($request->input('phone', ''));
        // 微信号
        $params['wechat'] = trim($request->input('wechat', ''));
        // 年龄
        $params['age'] = (int)trim($request->input('age', 0));
        // 住址
        $params['address'] = trim($request->input('address', ''));
        // 教育程度
        $params['education'] = trim($request->input('education', ''));
        // 银行卡号
        $params['bank_card'] = trim($request->input('bank_card', ''));
        // 操作版本号
        $params['version'] = (int)trim($request->input('version', 0));
        // 服务地区
        $params['region'] = $request->input('region', array());
        // 证书(数组)
        $params['paper'] = $request->input('paper', array());
        // 能力标签(数组)
        $params['label'] = $request->input('label', array());
        // 技能标签(数组)
        $params['skill'] = $request->input('skill', array());

        if ($params['name'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务人员姓名");
        }
        if ($params['phone'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务人员手机");
        }
        // 身份证号
        // if ($params['identify'] == '') {
        //     send_msg_json(ERROR_RETURN, "请填写服务人员身份证号");
        // }
        // if (!verify_identity($params['identify'])) {
        //     send_msg_json(ERROR_RETURN, "身份证号格式错误");
        // }
        // 验证手机号格式
        if (!verify_phone($params['phone'])) {
            send_msg_json(ERROR_RETURN, "手机号格式错误");
        }
        if ($params['address'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务人员现住址");
        }
        if ($params['bank_card'] == '') {
            send_msg_json(ERROR_RETURN, "请填写银行卡号");
        }
        // 验证银行卡号
        // if (!verify_bank_card($params['bank_card'])) {
        //     send_msg_json(ERROR_RETURN, "银行卡号格式错误");
        // }
        if (empty($params['age'])) {
            send_msg_json(ERROR_RETURN, "请填写服务人员年龄");
        }
        $return = $staffService->saveStaff($params);
        
        // 编写操作日志
        if (empty($params['id'])) {
            $logMsg = "添加员工信息，操作id为：".$return['staffId'];
        } else {
            $logMsg = "编辑员工信息，操作id为：".$return['staffId'];
        }
        // 写入日志
        write_log($accessToken, $logMsg);

        return send_msg_json(SUCCESS_RETURN, $return['returnMsg']);
    }

    /**
     * 逻辑删除服务人员
     *
     * @param Request $request
     * @return string
     */
    public function deleteStaff(Request $request)
    {
        $staffService = new StaffService;
        // 服务人员id
        $id = (int)trim($request->input('id', 0));
        // 操作版本号
        $version = (int)trim($request->input('version', 0));

        $staffService->deleteStaff($id, $version);
        // 访问令牌
        $accessToken = trim($request->header('accessToken', ''));
        // 写入日志
        write_log($accessToken, "删除服务人员，操作id为：".$id);

        return send_msg_json(SUCCESS_RETURN, "删除成功");
    }

    /**
     * 获取技能列表
     *
     * @param Request $request
     * @return string
     */
    public function getStaffSkillList(Request $request)
    {
        $staffService = new StaffService;
        // 服务分类id
        $params['service_category_id'] = (int)trim($request->input('service_category_id', 0));

        $pageNumber = (int)trim($request->input('pageNumber', 15));

        $list = $staffService->getStaffSkillList($params, $pageNumber);

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }

    /**
     * 审核员工技能
     *
     * @param Request $request
     * @return string
     */
    public function reviewStaffSkill(Request $request)
    {
        $staffService = new StaffService;
        // 员工技能id
        $id = (int)trim($request->input('id', 0));
        // 审核备注
        $remark = trim($request->input('remark', ''));

        $review = (int)trim($request->input('review', 0));

        $version = (int)trim($request->input('version', 0));

        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入员工技能id");
        }
        if (empty($review)) {
            send_msg_json(ERROR_RETURN, "请选择审核是否通过");
        }
        if ($remark == '') {
            send_msg_json(ERROR_RETURN, "请填写审核备注");
        }

        $staffSkillId = $staffService->reviewStaffSkill($id, $review, $remark, $version);
        // 访问令牌
        $accessToken = trim($request->header('accessToken',''));
        // 写入日志
        write_log($accessToken, "员工技能审核，操作id为：".$staffSkillId);
        
        return send_msg_json(SUCCESS_RETURN, "审核成功");
    }

    /**
     * 逻辑删除员工技能，物理删除技能材料标签关系表
     *
     * @param Request $request
     * @return void
     */
    public function deleteStaffSkill(Request $request)
    {
        $staffService = new StaffService;
        // 技能id
        $id = (int)trim($request->input('id', 0));
        // 版本号
        $version = (int)trim($request->input('version', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入员工技能id");
        }
        $staffService->deleteStaffSkill($id, $version);
        // 访问令牌
        $accessToken = trim($request->header('accessToken',''));
        // 写入日志
        write_log($accessToken, "删除员工技能，操作id为：".$id);

        return send_msg_json(SUCCESS_RETURN, "删除成功");
    }
}
