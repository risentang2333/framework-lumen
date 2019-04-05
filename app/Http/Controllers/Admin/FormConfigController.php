<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\FormConfigService;

class FormConfigController extends Controller
{
    public function getFormConfig(Request $request)
    {
        $formConfigService = new FormConfigService;
        
        $data = $formConfigService->getFormConfig();

        return send_msg_json(SUCCESS_RETURN, "success", $data);
    }

    public function editFormConfig(Request $request)
    {
        $formConfigService = new FormConfigService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken',''));
        // 配置项
        $params['table'] = trim($request->input('table', ''));
        // 修改项id
        $params['id'] = (int)trim($request->input('id', 0));
        // 修改项名称
        $params['name'] = trim($request->input('name', ''));

        $params['version'] = (int)trim($request->input('version', 0));

        if ($params['table'] == '') {
            send_msg_json(ERROR_RETURN, "请传入配置表信息");
        }
        if ($params['name'] == '') {
            send_msg_json(ERROR_RETURN, "请传入修改项名称");
        }
        // 保存服务项目
        $formConfigService->editFormConfig($params);
        // 写入日志
        write_log($accessToken, '修改表单配置');
        return send_msg_json(SUCCESS_RETURN, '修改成功');
    }
}
