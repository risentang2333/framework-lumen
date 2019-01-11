<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\StaffService;

class StaffController extends Controller
{
    public function getStaffList()
    {
        $staffService = new StaffService;

        $list = $staffService->getStaffList();

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }
}
