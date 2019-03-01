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
        $params['code'] = trim($request->input('code', ''));
        // 手机号
        $params['phone'] = trim($request->input('phone', ''));
        // 一页几条，默认15条
        $pageNumber = (int)trim($request->input('pageNumber', 15));

        $list = $orderService->getOrderList($params, $pageNumber);

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }

    public function getOrder(Request $request)
    {
        $orderService = new OrderService;
        // 订单id
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入订单id");
        }

        $order = $orderService->getOrderById($id)->toArray();

        return send_msg_json(SUCCESS_RETURN, "success", $order);
    }

    public function createOrder(Request $request)
    {
        $orderService = new OrderService;

        $accessToken = trim($request->header('accessToken',''));

        $params['id'] = (int)trim($request->input('id', 0));

        $params['manager_id'] = (int)trim($request->input('manager_id', 0));

        $params['manager_name'] = trim($request->input('manager_name', ''));

        $params['user_name'] = trim($request->input('user_name', ''));

        $params['phone'] = trim($request->input('phone', ''));

        $params['service_item_id'] = (int)trim($request->input('service_item_id', 0));

        $params['service_item_name'] = trim($request->input('service_item_name', ''));

        $params['service_address'] = trim($request->input('service_address', ''));

        $params['service_start_time'] = (int)trim($request->input('service_start_time', 0));
        
        $params['service_end_time'] = (int)trim($request->input('service_end_time', 0));

        $params['sourse'] = (int)trim($request->input('sourse', 0));

        $params['remark'] = trim($request->input('remark', ''));

        if (empty($params['service_item_id'])) {
            send_msg_json(ERROR_RETURN, "请选择服务项目");
        }
        if ($params['service_item_name'] == '') {
            send_msg_json(ERROR_RETURN, "请传入服务项目名");
        }
        if ($params['user_name'] == '') {
            send_msg_json(ERROR_RETURN, "请填写客户名");
        }
        if ($params['phone'] == '') {
            send_msg_json(ERROR_RETURN, "请填写客户手机号");
        }
        if ($params['service_address'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务地址");
        }
        if (empty($params['service_start_time']) || empty($params['service_end_time'])) {
            send_msg_json(ERROR_RETURN, "请选择服务时间");
        }
        if (empty($params['sourse'])) {
            send_msg_json(ERROR_RETURN, "请选择订单渠道");
        }
        // 保存需求订单
        $orderId = $orderService->createOrder($params, $accessToken);
        // 编写操作日志
        $logMsg = "添加订单，订单id为：".$orderId;
        // 写入日志
        write_log($accessToken, $logMsg);
        return send_msg_json(SUCCESS_RETURN, "添加成功");
    }

    public function editOrder(Request $request)
    {
        $orderService = new OrderService;

        $accessToken = trim($request->header('accessToken',''));

        $params['id'] = (int)trim($request->input('id', 0));

        $params['service_item_id'] = (int)trim($request->input('service_item_id', 0));

        $params['service_item_name'] = trim($request->input('service_item_name', ''));

        $params['user_id'] = (int)trim($request->input('user_id', 0));

        $params['user_name'] = trim($request->input('user_name', ''));

        $params['phone'] = trim($request->input('phone', ''));

        $params['service_address'] = trim($request->input('service_address', ''));

        $params['service_start_time'] = (int)trim($request->input('service_start_time', 0));
        
        $params['service_end_time'] = (int)trim($request->input('service_end_time', 0));

        $params['sourse'] = trim($request->input('sourse', 0));

        $params['remark'] = trim($request->input('remark', ''));

        $params['version'] = (int)trim($request->input('version', 0));

        if (empty($params['service_item_id'])) {
            send_msg_json(ERROR_RETURN, "请选择服务项目");
        }
        if ($params['service_item_name'] == '') {
            send_msg_json(ERROR_RETURN, "请传入服务项目名");
        }
        if ($params['user_name'] == '') {
            send_msg_json(ERROR_RETURN, "请填写客户名");
        }
        if ($params['phone'] == '') {
            send_msg_json(ERROR_RETURN, "请填写客户手机号");
        }
        if ($params['service_address'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务地址");
        }
        if (empty($params['service_start_time']) || empty($params['service_end_time'])) {
            send_msg_json(ERROR_RETURN, "请选择服务时间");
        }
        if (empty($params['sourse'])) {
            send_msg_json(ERROR_RETURN, "请选择订单渠道");
        }
        // 保存需求订单
        $return = $orderService->saveOrder($params, $accessToken);
        // 编写操作日志
        if (empty($params['id'])) {
            $logMsg = "添加需求订单，操作id为：".$return['orderId'];
        } else {
            $logMsg = "编辑需求订单，操作id为：".$return['orderId'];
        }
        // 写入日志
        write_log($accessToken, $logMsg);
        return send_msg_json(SUCCESS_RETURN, $return['returnMsg']);
    }

    public function sign(Request $request)
    {
        $orderService = new OrderService;

        $accessToken = trim($request->header('accessToken',''));
        // 订单id
        $params['id'] = (int)trim($request->input('id', 0));
        // 服务人员id
        $params['staff_id'] = (int)trim($request->input('staff_id', 0));
        // 服务周期单位
        $params['unit'] = trim($request->input('unit', ''));
        // 服务次数
        $params['service_count'] = (int)trim($request->input('service_count', 0));
        // 单价
        $params['unit_price'] = trim($request->input('unit_price', '0.00'));
        // 总价
        $params['total_price'] = trim($request->input('total_price', '0.00'));
        // 是否代发工资
        $params['pay_wage'] = (int)trim($request->input('pay_wage', 0));
        // 代发工资次数
        $params['wage_count'] = (int)trim($request->input('wage_count', 0));
        // 代发工资金额
        $params['wage_price'] = trim($request->input('wage_price', '0.00'));

        $params['version'] = (int)trim($request->input('version', 0));

        if (empty($params['id'])) {
            send_msg_json(ERROR_RETURN, "请传入订单id");
        }
        if (empty($params['staff_id'])) {
            send_msg_json(ERROR_RETURN, "请传入服务人员id");
        }
        if ($params['unit'] == '') {
            send_msg_json(ERROR_RETURN, "请选择服务周期");
        }
        $orderService->sign($params);

        write_log($accessToken, "订单签约成功，操作id：".$params['order_id']);

        return send_msg_json(SUCCESS_RETURN, "签约成功");
    }

    public function refuse(Request $request)
    {
        $orderService = new OrderService;

        $accessToken = trim($request->header('accessToken',''));
        // 订单id
        $params['id'] = (int)trim($request->input('id', 0));
        // 服务人员id
        $params['staff_id'] = (int)trim($request->input('staff_id', 0));
        // 拒签日志
        $params['refuse_log'] = trim($request->input('refuse_log', ''));
        if (empty($params['id'])) {
            send_msg_json(ERROR_RETURN, "请传入订单id");
        }
        if (empty($params['staff_id'])) {
            send_msg_json(ERROR_RETURN, "请传入服务人员id");
        }
        $orderService->refuse($params);

        write_log($accessToken, "订单面试拒签，订单id：".$params['order_id']."服务人员id：".$params['order_id']);
        
        return send_msg_json(SUCCESS_RETURN, "拒签成功");
    }
}
