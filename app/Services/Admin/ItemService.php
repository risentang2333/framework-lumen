<?php

namespace App\Services\Admin;

use App\Entities\ServiceItems;
use App\Entities\ServiceCategories;
use Illuminate\Support\Facades\DB;

class ItemService 
{
    /**
     * 员工列表查询字段
     *
     * @var array
     */
    private $itemList = [
        'id',
        'service_category_id',
        'service_name',
        'status',
        'created_at',
        'version',
    ];
    /**
     * 获取服务项目列表
     *
     * @param array $params
     * @param integer $pageNumber
     * @return string
     */
    public function getItemList($params, $pageNumber = 15)
    {
        $list = ServiceItems::select($this->itemList)
            ->where(function ($query) use ($params){
                // 逻辑删除判断
                $query->where('status', 0);
                // 如果有技能id搜索项
                if ($params['service_category_id']) {
                    $query->where('service_category_id',$params['service_category_id']);
                }
                // 如果有姓名搜索项
                if ($params['service_name']) {
                    $query->where('service_name','like','%'.$params['service_name'].'%');
                }
            })
            ->paginate($pageNumber)
            ->toArray();
        return $list;
    }
    /**
     * 通过id获得服务项目
     *
     * @param int $id
     * @return array
     */
    public function getItemById($id)
    {
        $item = ServiceItems::select(['id','service_category_id','service_name','status'])
            ->where(['status'=>0,'id'=>$id])->first();
        if (empty($item)) {
            send_msg_json(ERROR_RETURN, "该服务项目不存在");
        }
        return $item;
    }

    public function saveItem($params)
    {
        if (empty($params['id'])) {
            $item = new ServiceItems;
            // 创建时间
            $item->created_at = time();
            $returnMsg = '添加成功';
        } else {
            $item = ServiceItems::find($id);
            if (empty($item)) {
                send_msg_json(ERROR_RETURN, "该服务不存在");
            }
            if ($item->version != $params['version']) {
                send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
            }
            // 版本号+1
            $item->version = $params['version']+1;
            // 返回信息
            $returnMsg = '编辑成功';
        }
        // 服务分类id
        $item->service_category_id = $params['service_category_id'];
        // 服务项目名
        $item->service_name = $params['service_name'];
        // 保存
        $item->save();

        return array(
            'returnMsg'=>$returnMsg,
            'itemId'=>$item->id
        );
    }

    /**
     * 逻辑删除员工
     *
     * @param int $id 员工id
     * @param int $version
     * @return void
     */
    public function deleteItem($id, $version)
    {
        $item = ServiceItems::where('status', 0)->find($id);
        if (empty($item)) {
            send_msg_json(ERROR_RETURN, "该员工不存在");
        }
        if ($item->version != $version) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        
        $item->status = 1;

        return $item->save();
    }
}
