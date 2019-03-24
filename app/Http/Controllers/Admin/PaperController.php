<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\PaperService;

class PaperController extends Controller
{
    public function getPaperList(Request $request)
    {
        $paperService = new PaperService;
        // 证件类型名
        $params['name'] = trim($request->input('name', ''));
        // 启用/禁用
        $params['type'] = trim($request->input('type', ''));
        // 一页几条，默认15条
        $pageNumber = (int)trim($request->input('pageNumber', 15));

        $list = $paperService->getPaperList($params, $pageNumber);

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }

    public function getPaper(Request $request)
    {
        $paperService = new PaperService;
        // 分类id
        $id = (int)trim($request->input('id', 0));
        // 根据id获取服务分类
        $paperCategory = $paperService->getPaperById($id)->toArray();

        return send_msg_json(SUCCESS_RETURN, "success", $paperCategory);
    }

    public function editPaper(Request $request)
    {
        $paperService = new PaperService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken',''));

        $params['id'] = (int)trim($request->input('id', 0));

        $params['name'] = trim($request->input('name', ''));

        $params['type'] = trim($request->input('type', ''));

        $params['version'] = (int)trim($request->input('version', 0));
        
        if ($params['name'] == '') {
            send_msg_json(ERROR_RETURN, "请填写证件类型名");
        }
        if ($paperService->checkSameName($params['name'])) {
            send_msg_json(ERROR_RETURN, "分类名重复");
        }
        if (!in_array($params['type'], array('enable','disable'))) {
            send_msg_json(ERROR_RETURN, "启用/禁用格式错误");
        }
        // 保存服务项目
        $return = $paperService->savePaper($params);
        // 编写操作日志
        if (empty($params['id'])) {
            $logMsg = "添加证件类型，操作id为：".$return['paperId'];
        } else {
            $logMsg = "编辑证件类型，操作id为：".$return['paperId'];
        }
        // 写入日志
        write_log($accessToken, $logMsg);
        return send_msg_json(SUCCESS_RETURN, $return['returnMsg']);
    }

    public function changePaperType(Request $request)
    {
        $paperService = new PaperService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken', ''));
        // 证件类型id
        $id = (int)trim($request->input('id', 0));
        // 启用/禁用状态
        $type = trim($request->input('type', ''));
        // 操作版本号
        $version = (int)trim($request->input('version', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入证件类型id");
        }
        if (!in_array($type, array('enable','disable'))) {
            send_msg_json(ERROR_RETURN, "启用/禁用格式错误");
        }
        // 判断状态格式
        $returnMsg = $paperService->changePaperType($id, $type, $version);
        if ($type == 'enable') {
            $logMsg = "启用证件，操作id为：".$id;
        } else if ($type == 'disable') {
            $logMsg = "停用证件，操作id为：".$id;
        }
        // 写入日志
        write_log($accessToken, $logMsg);

        return send_msg_json(SUCCESS_RETURN, $returnMsg);
    }
}
