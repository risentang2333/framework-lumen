<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\OrderService;

class OrderController extends Controller
{
    /**
     * 获取订单列表
     *
     * @param Request $request
     * @return string
     */
    public function getOrderList(Request $request)
    {
        $orderService = new OrderService;
        // 服务分类id
        $params['service_item_id'] = (int)trim($request->input('service_item_id', 0));
        // 订单来源
        $params['source'] = (int)trim($request->input('source', 0));
        // 订单号
        $params['code'] = $request->input('code', '');
        // 手机号
        $params['phone'] = $request->input('phone', '');
        // 一页几条，默认15条
        $pageNumber = (int)trim($request->input('pageNumber', 15));

        $list = $orderService->getOrderList($params, $pageNumber);

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }
}
