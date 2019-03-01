<?php

namespace App\Services\Admin;

use App\Entities\Orders;
use App\Entities\Users;
use App\Entities\OrderStaff;
use App\Entities\OrderLogs;
use Illuminate\Support\Facades\DB;

class OrderService 
{
    /**
     * 订单列表字段
     *
     * @var array
     */
    private $orderList = [
        'id',
        'code',
        'phone',
        'source',
        'created_at',
        'service_item_id',
        'service_item_name'
    ];

    /**
     * 获取订单列表
     *
     * @param array $params
     * @param integer $pageNumber
     * @return array
     */
    public function getOrderList($params, $pageNumber = 15)
    {
        $list = Orders::select($this->orderList)
            ->where(function ($query) use ($params){
                // 逻辑删除判断
                $query->where('status', 0);
                // 如果有姓名搜索项
                if ($params['code']) {
                    $query->where('code','like','%'.$params['code'].'%');
                }
                // 如果有手机号搜索项
                if ($params['phone']) {
                    $query->where('phone','like','%'.$params['phone'].'%');
                }
                // 如果有技能id搜索项
                if ($params['service_item_id']) {
                    $query->where('service_item_id',$params['service_item_id']);
                }
                // 如果有姓名搜索项
                if ($params['source']) {
                    $query->where('source', $params['source']);
                }
            })
            ->paginate($pageNumber)
            ->toArray();
        return $list;
    }

    /**
     * 根据订单id获取需求订单
     *
     * @param int $id
     * @return object
     */
    public function getOrderById($id)
    {
        $order = Orders::select(['id','user_id','user_name','phone','service_item_id','service_item_name','service_address','service_start_time','service_end_time','sourse','remark'])->where(['id'=>$id,'status'=>0])->first();
        if (empty($order)) {
            send_msg_json(ERROR_RETURN, "该订单不存在");
        }
        return $order;
    }

    public function createOrder($params, $accessToken)
    {
        // 新增订单
        if (empty($this->getUserByPhone($params['phone']))) {
            $params['user_id'] = $this->saveUser(array(
                'phone' => $params['phone'],
                'name' => $params['name']
            ));
        }
        $order = new Orders;
        $order->created_at = time();
        $order->manager_id = $params['manager_id'];
        $order->manager_name = $params['manager_name'];
        $order->user_id = $params['user_id'];
        $order->user_name = $params['user_name'];
        $order->phone = $params['phone'];
        $order->service_item_id = $params['service_item_id'];
        $order->service_item_name = $params['service_item_name'];
        $order->service_start_time = $params['service_start_time'];
        $order->service_end_time = $params['service_end_time'];
        $order->service_address = $params['service_address'];
        $order->sourse = $params['sourse'];
        $order->remark = $params['remark'];
        // 待匹配
        $order->type = 1;
        DB::transaction(function () use ($order) {
            $order->save();

            $code = date("YmdHis").sprintf("%04d", rand(0,9999)).sprintf("%07d", $order->id);
            $order->code = $code;
            $order->save();
        });
        
        return $order->id;
    }

    /**
     * 创建或编辑需求订单
     *
     * @param array $params
     * @return array
     */
    public function saveOrder($params, $accessToken)
    {
        // 执行成功提示
        $returnMsg = '';
        // 新增订单
        if (empty($params['id'])) {
            if (empty($this->getUserByPhone($params['phone']))) {
                $params['user_id'] = $this->saveUser(array(
                    'phone' => $params['phone'],
                    'name' => $params['name']
                ));
            }
            $order = new Orders;
            $order->type = 1;
            $order->created_at = time();
            $returnMsg = '添加成功';
        // 编辑订单
        } else {
            if (!empty($this->getUserByPhone($params['phone'])) && !empty($params['user_id'])) {
                $this->saveUser(array(
                    'id' => $params['user_id'],
                    'phone' => $params['phone'],
                    'name' => $params['name'],
                    'accessToken' => $accessToken
                ));
            }
            $order = Orders::where('status', 0)->find($params['id']);
            if (empty($order)) {
                send_msg_json(ERROR_RETURN, "该订单不存在");
            }
            if ($order->version != $params['version']) {
                send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
            }
            $order->version = $params['version']+1;
            $returnMsg = '编辑成功';
        }
        $order->manager_id = $params['manager_id'];
        $order->manager_name = $params['manager_name'];
        $order->service_item_id = $params['service_item_id'];
        $order->service_item_name = $params['service_item_name'];
        $order->user_id = $params['user_id'];
        $order->user_name = $params['user_name'];
        $order->phone = $params['phone'];
        $order->service_address = $params['service_address'];
        $order->service_start_time = $params['service_start_time'];
        $order->service_end_time = $params['service_end_time'];
        $order->sourse = $params['sourse'];
        $order->remark = $params['remark'];

        $order->save();
        
        return array(
            'returnMsg'=>$returnMsg,
            'staffId'=>$order->id
        );
    }

    private function saveOrderStaff($orderId, $staff)
    {
        if (!empty($staff)) {
            array_walk($staff, function (&$item) use ($orderId) {
                OrderStaff::updateOrCreate(['id'=>$item['id']],['order_id'=>$orderId, 'staff_id'=>$item['id'], 'staff_name'=>$item['name']]);
            });
        }
        return true;
    }

    /**
     * 根据用户手机查询用户
     *
     * @param string $phone
     * @return object
     */
    private function getUserByPhone($phone)
    {
        $user = Users::where(['phone'=>$phone,'status'=>0])->first();

        return $user;
    }

    /**
     * 新增或编辑用户
     *
     * @param array $params
     * @return int
     */
    private function saveUser($params)
    {
        if (array_key_exists('id', $params)) {
            $user = Users::where('status', 0)->find($params['id']);
        } else {
            $user = new Users;
        }

        $user->phone = $params['phone'];
        $user->name = $params['name'];

        $user->save();
        write_log($accessToken, "新增用户，手机号：".$params['phone']);

        return $user->id;
    }

    public function sign($params)
    {
        $order = Orders::where('status', 0)->find($params['id']);
        if (empty($order)) {
            send_msg_json(ERROR_RETURN, "该订单不存在");
        }
        if ($order->version != $params['version']) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        $order->unit = $params['unit'];
        $order->service_count = $params['service_count'];
        $order->unit_price = $params['unit_price'];
        $order->total_price = $params['total_price'];
        $order->pay_wage = $params['pay_wage'];
        $order->wage_count = $params['wage_count'];
        $order->wage_price = $params['wage_price'];
        $order->version = $params['version']+1;

        DB::transaction(function () use ($order, $params) {

            $order->save();

            OrderStaff::where(['order_id'=>$params['order_id'], 'staff_id'=>$params['staff_id']])->update(['type'=>'sign']);
        });

        return true;
    }

    public function refuse($params){

        DB::transaction(function () {

            OrderStaff::where(['order_id'=>$params['order_id'], 'staff_id'=>$params['staff_id']])->update(['type'=>'refuse']);

            $this->writeOrderLog($params['order_id'], $message, 'refuse');
        });

        return true;
    }
    

    public function writeOrderLog($orderId, $message, $type = 'maintain')
    {
        OrderLogs::insert(['order_id'=>$orderId, 'message'=>$message, 'type'=>$type]);

        return true;
    }
}
