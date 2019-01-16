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

        $params['name'] = trim($request->input('name',''));

        $list = $staffService->getStaffList($params);

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }

    /**
     * 获取地区列表
     *
     * @return string
     */
    public function getAreaList()
    {
        $staffService = new StaffService;

        $areas = $staffService->getAreaForTree();

        $tree = $staffService->getTree($areas);

        return $tree;
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

        return send_msg_json(SUCCESS_RETURN, "success", $staff);
    }

    /**
     * 编辑服务人员
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
        
        $staffService->saveStaff($params);
        
        return send_msg_json(SUCCESS_RETURN, "编辑成功");
    }
}
