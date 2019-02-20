<?php

namespace App\Services\Admin;

use App\Entities\ServiceItems;
use App\Entities\ServiceCategories;
use Illuminate\Support\Facades\DB;

class ServiceService 
{
    /**
     * 员工列表查询字段
     *
     * @var array
     */
    private $itemList = [
        'id',
        'service_category_id',
        'service_item_name',
        'status',
        'created_at',
        'type',
        'version',
    ];

    private $categoryList = [
        'id',
        'name',
        'parent_id',
        'status',
        'type',
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
                if ($params['service_item_name']) {
                    $query->where('service_item_name','like','%'.$params['service_item_name'].'%');
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
        $item = ServiceItems::select(['id','service_category_id','service_item_name','status'])
            ->where(['status'=>0,'id'=>$id])->first();
        if (empty($item)) {
            send_msg_json(ERROR_RETURN, "该服务项目不存在");
        }
        return $item;
    }

    /**
     * 编辑/添加服务项目
     *
     * @param [type] $params
     * @return array
     */
    public function saveItem($params)
    {
        $returnMsg = '';
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
        $item->service_item_name = $params['service_item_name'];
        // 保存
        $item->save();

        return array(
            'returnMsg'=>$returnMsg,
            'itemId'=>$item->id
        );
    }

    /**
     * 删除服务项目
     *
     * @param [type] $id
     * @param [type] $version
     * @return void
     */
    public function deleteItem($id, $version)
    {
        $item = ServiceItems::where('status', 0)->find($id);
        if (empty($item)) {
            send_msg_json(ERROR_RETURN, "该服务不存在");
        }
        if ($item->version != $version) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        
        $item->status = 1;

        return $item->save();
    }

    /**
     * 启用/禁用服务项目
     *
     * @param [type] $id
     * @param [type] $type
     * @param [type] $version
     * @return void
     */
    public function changeItemType($id, $type, $version)
    {
        $item = ServiceItems::where('status', 0)->find($id);
        if (empty($item)) {
            send_msg_json(ERROR_RETURN, "该服务不存在");
        }
        if ($item->version != $version) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        $item->type = $type;
        $item->save();
        // 返回信息
        $returnMsg = $type == 'enable' ? '启用成功' : '禁用成功';

        return $returnMsg;
    }

    public function getCategoryList($params, $pageNumber = 15)
    {
        $list = ServiceCategories::select($this->categoryList)
            ->where(function ($query) use ($params){
                // 逻辑删除判断
                $query->where('status', 0);
                // 如果有姓名搜索项
                if ($params['name']) {
                    $query->where('name','like','%'.$params['name'].'%');
                }
            })
            ->paginate($pageNumber)
            ->toArray();
        return $list;
    }

    public function getCategoryById($id)
    {
        $item = ServiceItems::select(['id','name','parent_id','type','status'])
            ->where(['status'=>0,'id'=>$id])->first();
        if (empty($item)) {
            send_msg_json(ERROR_RETURN, "该服务项目不存在");
        }
        return $item;
    }
}
