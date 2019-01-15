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
}
