<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\ItemService;

class ItemController extends Controller
{
    /**
     * 服务项目列表
     *
     * @param Request $request
     * @return string
     */
    public function getItemList(Request $request)
    {
        $itemService = new ItemService;
        // 服务分类id
        $params['service_category_id'] = (int)trim($request->input('service_category_id', 0));
        // 服务项目名
        $params['service_name'] = $request->input('service_name', '');
        // 一页几条，默认15条
        $pageNumber = (int)trim($request->input('pageNumber', 15));

        $list = $itemService->getItemList($params, $pageNumber);

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }

    /**
     * 获取服务项目
     *
     * @param Request $request
     * @return string
     */
    public function getItem(Request $request)
    {
        $itemService = new ItemService;
        // 订单id
        $id = (int)trim($request->input('id', 0));

        $item = $itemService->getItemById($id);

        return send_msg_json(SUCCESS_RETURN, "success", $item);
    }

    /**
     * 编辑服务项目
     *
     * @param Request $request
     * @return string
     */
    public function editItem(Request $request)
    {
        $itemService = new ItemService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken',''));

        $params['id'] = (int)trim($request->input('id', 0));

        $params['service_category_id'] = (int)trim($request->input('service_category_id', 0));

        $params['service_name'] = $request->input('service_name', '');

        $params['version'] = (int)trim($request->input('version', 0));
        
        if (empty($params['service_category_id'])) {
            send_msg_json(ERROR_RETURN, "请选择服务类别");
        }
        if ($params['service_name'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务名称");
        }
        // 保存服务项目
        $return = $itemService->saveItem($params);
        // 编写操作日志
        if (empty($params['id'])) {
            $logMsg = "添加服务项目，操作id为：".$return['itemId'];
        } else {
            $logMsg = "编辑服务项目，操作id为：".$return['itemId'];
        }
        // 写入日志
        // write_log($accessToken, $logMsg);
        return send_msg_json(SUCCESS_RETURN, $return['returnMsg']);
    }

    public function deleteItem(Request $request)
    {
        $itemService = new ItemService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken', ''));
        // 服务人员id
        $id = (int)trim($request->input('id', 0));
        // 操作版本号
        $version = (int)trim($request->input('version', 0));

        $itemService->deleteItem($id, $version);
        // 写入日志
        // write_log($accessToken, "删除服务人员，操作id为：".$id);

        return send_msg_json(SUCCESS_RETURN, "删除成功");
    }
}
