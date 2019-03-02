<?php

namespace App\Services\Admin;

use App\Entities\Orders;
use App\Entities\Users;
use App\Entities\Staff;
use App\Entities\OrderStaff;
use App\Entities\OrderFiles;
use App\Entities\OrderMaintainLogs;
use App\Entities\OrderSignLogs;
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
        'service_category_id',
        'name'
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
                if ($params['service_category_id']) {
                    $query->where('service_category_id',$params['service_category_id']);
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
        $order = Orders::where(['id'=>$id,'status'=>0])->first();
        
        if (empty($order)) {
            send_msg_json(ERROR_RETURN, "该订单不存在");
        }
        return $order;
    }

    public function getOrderStaffById($id)
    {
        return $orderStaff = OrderStaff::where(['order_id'=>$id, 'status'=>0])->get()->toArray();
    }

    public function getOrderFileByid($id)
    {
        return $orderFile = OrderFiles::where(['order_id'=>$id, 'status'=>0])->get()->toArray();
    }

    public function getOrderLogById($id, $type)
    {
        $orderLog = [];
        if ($type == 'maintain') {
            $orderLog = OrderMaintainLogs::where(['order_id'=>$id])->get()->toArray();
        } else if ($type == 'sign') {
            $orderLog = OrderSignLogs::where(['order_id'=>$id])->get()->toArray();
        }

        return $orderLog;
    }

    public function createOrder($params, $accessToken)
    {
        // 新增订单
        $user = $this->getUserByPhone($params['phone']);
        if (empty($user)) {
            $params['user_id'] = $this->saveUser(array(
                'phone' => $params['phone'],
                'name' => $params['user_name']
            ), $accessToken);
        } else {
            $params['user_id'] = $user->id;
        }
        $order = new Orders;
        $order->created_at = time();
        $order->manager_id = $params['manager_id'];
        $order->manager_name = $params['manager_name'];
        $order->user_id = $params['user_id'];
        $order->user_name = $params['user_name'];
        $order->phone = $params['phone'];
        $order->service_category_id = $params['service_category_id'];
        $order->name = $params['name'];
        $order->service_start_time = $params['service_start_time'];
        $order->service_end_time = $params['service_end_time'];
        $order->service_address = $params['service_address'];
        $order->source = $params['source'];
        $order->remark = $params['remark'];
        // 待匹配
        $order->type = 1;
        DB::transaction(function () use ($order) {
            $order->save();

            $code = date("Ymd").sprintf("%04d", rand(0,9999)).sprintf("%07d", $order->id);
            $order->code = $code;
            $order->save();
        });
        
        return $order->id;
    }

    public function editOrder($params, $accessToken)
    {
        $order = Orders::where('status', 0)->find($params['id']);
        if (empty($order)) {
            send_msg_json(ERROR_RETURN, "该订单不存在");
        }
        if ($order->version != $params['version']) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        $order->version = $params['version']+1;

        $order->service_category_id = $params['service_category_id'];
        $order->name = $params['name'];
        $order->user_name = $params['user_name'];
        $order->phone = $params['phone'];
        $order->service_address = $params['service_address'];
        $order->service_start_time = $params['service_start_time']/1000;
        $order->service_end_time = $params['service_end_time']/1000;
        $order->source = $params['source'];
        $order->remark = $params['remark'];

        $order->save();

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
    private function saveUser($params, $accessToken)
    {
        $user = new Users;

        $user->phone = $params['phone'];
        $user->name = $params['name'];

        $user->save();
        if (!array_key_exists('id', $params)) {
            write_log($accessToken, "新增用户，手机号：".$params['phone']);
        }

        return $user->id;
    }

    public function createOrderStaff($params)
    {
        DB::transaction(function () use ($params) {
            OrderStaff::updateOrCreate(['order_id'=>$params['order_id'], 'staff_id'=>$params['staff_id'], 'status'=>0],['order_id'=>$params['order_id'], 'staff_id'=>$params['staff_id'], 'staff_name'=>$params['staff_name']]);
        
            Staff::where(['id'=>$params['staff_id'], 'status'=>0])->update(['type'=>'normal']);

            Orders::where(['id'=>$params['order_id'], 'status'=>0])->update(['type'=>2]);
        });
        
        return true;
    }

    public function deleteOrderStaff($id)
    {
        OrderStaff::where('id', $id)->update(['status'=>1]);

        return true;
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
        $order->type = 3;
        $order->version = $params['version']+1;

        $staffIds = OrderStaff::select(['staff_id'])->where(['order_id'=>1, 'status'=>0])->pluck('staff_id')->toArray();
        
        DB::transaction(function () use ($order, $params, $staffIds) {
            // 保存订单
            $order->save();
            // 修改订单服务人员
            OrderStaff::where(['order_id'=>$params['id'], 'staff_id'=>$params['staff_id'], 'status'=>0])->update(['type'=>'sign']);
            // 修改员服务人员表变为正常
            Staff::whereIn('id', $staffIds)->where('status',0)->update(['type'=>'normal']);

            Staff::where(['id'=>$params['staff_id'],'status'=>0])->update(['type'=>'sign']);
            
            $this->saveOrderFile();
        });

        return true;
    }

    private function saveOrderFile()
    {
        return true;
    }

    public function refuse($params){

        OrderStaff::where(['order_id'=>$params['order_id'], 'staff_id'=>$params['staff_id'],'status'=>0])->update(['type'=>'refuse']);

        $this->writeSignLog(array(
            'order_id'=>$params['order_id'],
            'staff_id'=>$params['staff_id'],
            'staff_name'=>$params['staff_name'],
            'message'=>$params['message']
        ));

        return true;
    }

    public function writeSignLog($params)
    {
        OrderSignLogs::insert(['order_id'=>$params['order_id'], 'staff_id'=>$params['staff_id'], 'staff_name'=>$params['staff_name'], 'message'=>$params['message'], 'type'=>'maintain']);

        return true;
    }
    
    public function writeMaintainLog($orderId, $message)
    {
        OrderLogs::insert(['order_id'=>$orderId, 'staff_id'=>0, 'message'=>$message]);

        return true;
    }

    public function cancelOrderById($id)
    {
        Orders::where(['id'=>$id, 'status'=>0])->update(['type'=>4]);

        return true;
    }

    public function completeOrderById($id)
    {
        Orders::where(['id'=>$id, 'status'=>0])->update(['type'=>5]);

        return true;
    }
}
