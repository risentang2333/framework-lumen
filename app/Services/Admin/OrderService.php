<?php

namespace App\Services\Admin;

use App\Entities\Orders;

use Illuminate\Support\Facades\DB;

class OrderService 
{
    private $orderList = [
        'id',
        'code',
        'phone',
        'source',
        'created_at',
        'service_item_id',
        'service_name'
    ];
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
    public function getDemandOrderById($id)
    {
        $order = Orders::select(['id','code','user_id','user_name','phone','service_item_id','service_name','service_address','service_start_time','service_end_time','sourse'])->where('id', $id)->first();
        if (empty($order)) {
            send_msg_json(ERROR_RETURN, "该订单不存在");
        }
        
        return $order->toArray();
    }
}
