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
        $params['service_category_id'] = trim($request->input('service_category_id',''));
        // 能力标签id集合
        $params['ability_ids'] = $request->input('ability_ids','');

        $list = $staffService->getStaffList($params);

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }

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
     * 获取服务人员信息
     *
     * @param Request $request
     * @return string
     */
    public function getStaff(Request $request)
    {
        $staffService = new StaffService;
        // 工作人员id
        $id = trim($request->input('id', ''));
        if ($id == '') {
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
        $params['id'] = trim($request->input('id', ''));
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
        $params['version'] = trim($request->input('version', 0));
        // 技能标签
        $params['labels'] = $request->input('labels', array());

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
        if ($params['age'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务人员年龄");
        }
        if ($params['bank_card'] == '') {
            send_msg_json(ERROR_RETURN, "请填写银行卡号");
        }
        if ($params['address'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务人员现住址");
        }
        if (empty($params['labels'])) {
            send_msg_json(ERROR_RETURN, "请填写技能标签");
        }
        
        $returnMsg = $staffService->saveStaff($params);
        
        return send_msg_json(SUCCESS_RETURN, $returnMsg);
    }
}
