<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\AbilityService;

class AbilityController extends Controller
{
    public function getAbilityList(Request $request)
    {
        $abilityService = new AbilityService;
        // 能力标签名
        $params['name'] = $request->input('name', '');
        // 一页几条，默认15条
        $pageNumber = (int)trim($request->input('pageNumber', 15));

        $list = $abilityService->getAbilityList($params, $pageNumber);

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }

    public function getAbility(Request $request)
    {
        
    }

    public function editAbility(Request $request)
    {
        
    }

    public function deleteAbility(Request $request)
    {
        
    }
}
