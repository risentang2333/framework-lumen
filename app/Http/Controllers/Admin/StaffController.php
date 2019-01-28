<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\StaffService;

class StaffController extends Controller
{
    /**
     * 获取地区列表
     *
     * @return string
     */
    public function getAreaTree()
    {
        $staffService = new StaffService;

        $areas = $staffService->getAreaForTree();

        $tree = $staffService->getTree($areas);

        return send_msg_json(SUCCESS_RETURN, "success", $tree);
    }

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
        $params['service_category_id'] = (int)trim($request->input('service_category_id',''));
        // 能力标签id集合
        $params['ability_ids'] = $request->input('ability_ids','');

        $list = $staffService->getStaffList($params);

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
        // 能力
        $label = $staffService->getLabelByStaffId($id)->toArray();
        // 技能标签材料证明集合
        $skill = $staffService->getSkillLabelPaperByStaffId($id);

        $staff['paper'] = $paper;
        $staff['label'] = $label;
        $staff['skill'] = $skill;

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
        // 服务人员id
        $params['id'] = (int)trim($request->input('id', 0));
        // 服务人员姓名
        $params['name'] = trim($request->input('name', ''));
        // 服务人员手机号
        $params['phone'] = trim($request->input('phone', ''));
        // 年龄
        $params['age'] = trim($request->input('age', ''));
        // 住址
        $params['address'] = trim($request->input('address', ''));
        // 银行卡号
        $params['bank_card'] = trim($request->input('bank_card', ''));
        // 操作版本号
        $params['version'] = (int)trim($request->input('version', 0));
        // 证书
        $params['papers'] = $request->input('papers', array());
        // 能力标签
        $params['labels'] = $request->input('labels', array());
        // 技能标签
        $params['skills'] = $request->input('skills', array());

        if ($params['name'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务人员姓名");
        }
        if ($params['phone'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务人员手机");
        }
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
        if ($params['age'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务人员年龄");
        }
        $return = $staffService->saveStaff($params);
        // 访问令牌
        $accessToken = trim($request->header('accessToken',''));
        // 编写操作日志
        if (empty($id)) {
            $logMsg = "添加员工信息，操作id为：".$return['staffId'];
        } else {
            $logMsg = "编辑员工信息，操作id为：".$return['staffId'];
        }
        // 写入日志
        write_log($accessToken, $logMsg);

        return send_msg_json(SUCCESS_RETURN, $return['returnMsg']);
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
        $params['service_category_id'] = (int)trim($request->input('service_category_id',''));

        $list = $staffService->getStaffSkillList($params);

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
        $staffSkillId = $staffService->deleteStaffSkill($id, $version);
        // 访问令牌
        $accessToken = trim($request->header('accessToken',''));
        // 写入日志
        write_log($accessToken, "删除员工技能，操作id为：".$staffSkillId);

        return send_msg_json(SUCCESS_RETURN, "删除成功");
    }
}
