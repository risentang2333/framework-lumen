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
        $params['service_category_id'] = (int)trim($request->input('service_category_id', 0));
        // 订单来源
        $params['source'] = (int)trim($request->input('source', 0));
        // 订单号
        $params['code'] = trim($request->input('code', ''));
        // 手机号
        $params['phone'] = trim($request->input('phone', ''));

        $params['type'] = (int)trim($request->input('type', 0));
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

        $data['order'] = $orderService->getOrderById($id)->toArray();

        $data['order_staff'] = $orderService->getOrderStaffById($id);

        $data['order_files'] = $orderService->getOrderFileByid($id);

        $data['order_maintain_logs'] = $orderService->getOrderLogById($id, 'maintain');
        
        $data['order_sign_logs'] = $orderService->getOrderLogById($id, 'sign');

        return send_msg_json(SUCCESS_RETURN, "success", $data);
    }

    public function createOrder(Request $request)
    {
        $orderService = new OrderService;

        $accessToken = trim($request->header('accessToken',''));

        $params['manager_id'] = (int)trim($request->input('manager_id', 0));

        $params['manager_name'] = trim($request->input('manager_name', ''));

        $params['user_name'] = trim($request->input('user_name', ''));

        $params['phone'] = trim($request->input('phone', ''));

        $params['service_category_id'] = (int)trim($request->input('service_category_id', 0));

        $params['name'] = trim($request->input('name', ''));

        $params['service_address'] = trim($request->input('service_address', ''));

        $params['service_start_time'] = (int)trim($request->input('service_start_time', 0));
        
        $params['service_end_time'] = (int)trim($request->input('service_end_time', 0));

        $params['source'] = (int)trim($request->input('source', 0));

        $params['remark'] = trim($request->input('remark', ''));

        if (empty($params['service_category_id'])) {
            send_msg_json(ERROR_RETURN, "请选择服务项目");
        }
        if ($params['name'] == '') {
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
        if (empty($params['source'])) {
            send_msg_json(ERROR_RETURN, "请选择订单渠道");
        }
        // 保存需求订单
        $orderId = $orderService->createOrder($params, $accessToken);
        // 写入日志
        write_log($accessToken, "添加订单，订单id为：".$orderId);
        return send_msg_json(SUCCESS_RETURN, "添加成功");
    }

    public function editOrder(Request $request)
    {
        $orderService = new OrderService;

        $accessToken = trim($request->header('accessToken',''));

        $params['id'] = (int)trim($request->input('id', 0));

        $params['service_item_id'] = (int)trim($request->input('service_item_id', 0));

        $params['service_item_name'] = trim($request->input('service_item_name', ''));

        $params['user_name'] = trim($request->input('user_name', ''));

        $params['phone'] = trim($request->input('phone', ''));

        $params['service_address'] = trim($request->input('service_address', ''));

        $params['service_start_time'] = (int)trim($request->input('service_start_time', 0));
        
        $params['service_end_time'] = (int)trim($request->input('service_end_time', 0));

        $params['source'] = trim($request->input('source', 0));

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
        if (empty($params['source'])) {
            send_msg_json(ERROR_RETURN, "请选择订单渠道");
        }
        // 保存需求订单
        $orderService->saveOrder($params, $accessToken);
        // 写入日志
        write_log($accessToken, "编辑订单，操作id为：".$params['id']);

        return send_msg_json(SUCCESS_RETURN, "编辑成功");
    }

    public function createOrderStaff(Request $request)
    {
        $orderService = new OrderService;

        $accessToken = trim($request->header('accessToken',''));
        // 订单id
        $params['order_id'] = (int)trim($request->input('order_id', 0));

        $params['staff_id'] = (int)trim($request->input('staff_id', 0));
        
        $params['staff_name'] = trim($request->input('staff_name', ''));

        if (empty($params['order_id'])) {
            send_msg_json(ERROR_RETURN, "请选择订单id");
        }
        if (empty($params['staff_id'])) {
            send_msg_json(ERROR_RETURN, "请选择服务人员id");
        }
        if ($params['staff_name'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务人员姓名");
        }
    
        $orderService->createOrderStaff($params);

        return send_msg_json(SUCCESS_RETURN, "添加成功");
    }

    public function deleteOrderStaff(Request $request)
    {
        $orderService = new OrderService;

        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入匹配人员id");
        }

        $orderService->deleteOrderStaff($id);

        return send_msg_json(SUCCESS_RETURN, "删除成功");
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
        $params['unit_price'] = sprintf("%.2f", trim($request->input('unit_price', 0)));
        // 总价
        $params['total_price'] = sprintf("%.2f", trim($request->input('total_price', 0)));
        // 是否代发工资
        $params['pay_wage'] = (int)trim($request->input('pay_wage', 0));
        // 代发工资次数
        $params['wage_count'] = (int)trim($request->input('wage_count', 0));
        // 代发工资金额
        $params['wage_price'] = sprintf("%.2f", trim($request->input('wage_price', 0)));

        $params['version'] = (int)trim($request->input('version', 0));
        // 合同图片
        $params['paper'] = $request->input('paper', array());

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

        write_log($accessToken, "订单签约成功，操作id：".$params['id']);

        return send_msg_json(SUCCESS_RETURN, "签约成功");
    }

    public function refuse(Request $request)
    {
        $orderService = new OrderService;

        $accessToken = trim($request->header('accessToken',''));
        // 订单id
        $params['order_id'] = (int)trim($request->input('order_id', 0));
        // 服务人员id
        $params['staff_id'] = (int)trim($request->input('staff_id', 0));
        // 服务人员姓名
        $params['staff_name'] = trim($request->input('staff_name', ''));
        // 拒签日志
        $params['message'] = trim($request->input('message', ''));
        if (empty($params['order_id'])) {
            send_msg_json(ERROR_RETURN, "请传入订单id");
        }
        $orderService->refuse($params);

        write_log($accessToken, "订单面试拒签，订单id：".$params['order_id']."服务人员id：".$params['order_id']);
        
        return send_msg_json(SUCCESS_RETURN, "拒签成功");
    }

    public function writeSignLog(Request $request)
    {
        $orderService = new OrderService;

        $accessToken = trim($request->header('accessToken',''));
        // 订单id
        $params['order_id'] = (int)trim($request->input('order_id', 0));

        $params['message'] = trim($request->input('message', ''));

        $params['staff_id'] = 0;

        $params['staff_name'] = '无';
        
        if (empty($params['order_id'])) {
            send_msg_json(ERROR_RETURN, "请传入订单id");
        }
        if ($params['message'] == '') {
            send_msg_json(ERROR_RETURN, "请传入日志");
        }
        
        $orderService->writeSignLog($params);

        return send_msg_json(SUCCESS_RETURN, "添加成功");
    }

    public function writeMaintainLog(Request $request)
    {
        $orderService = new OrderService;

        $accessToken = trim($request->header('accessToken',''));
        // 订单id
        $order_id = (int)trim($request->input('order_id', 0));

        $message = trim($request->input('message', ''));

        if (empty($order_id)) {
            send_msg_json(ERROR_RETURN, "请传入订单id");
        }
        if ($message == '') {
            send_msg_json(ERROR_RETURN, "请传入日志");
        }
        
        $orderService->writeMaintainLog($order_id, $message);

        return send_msg_json(SUCCESS_RETURN, "添加成功");
    }

    public function cancelOrder(Request $request)
    {
        $orderService = new OrderService;

        $accessToken = trim($request->header('accessToken',''));
        // 订单id
        $order_id = (int)trim($request->input('order_id', 0));

        $message = trim($request->input('message', ''));
        if (empty($order_id)) {
            send_msg_json(ERROR_RETURN, "请传入订单id");
        }
        $orderService->cancelOrderById($order_id, $message);

        write_log($accessToken, "取消订单，操作id：".$order_id);

        return send_msg_json(SUCCESS_RETURN, "取消成功");
    }

    public function completeOrder(Request $request)
    {
        $orderService = new OrderService;

        $accessToken = trim($request->header('accessToken',''));
        // 订单id
        $order_id = (int)trim($request->input('order_id', 0));

        $message = trim($request->input('message', ''));
        if (empty($order_id)) {
            send_msg_json(ERROR_RETURN, "请传入订单id");
        }

        $orderService->completeOrderById($order_id, $message);

        write_log($accessToken, "完成订单，操作id：".$order_id);
        
        return send_msg_json(SUCCESS_RETURN, "操作成功");
    }
}
