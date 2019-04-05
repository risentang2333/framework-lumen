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
        'type',
        'version'
    ];

    public function getCategoryForTree($selectAll = true)
    {
        $data = ServiceCategories::select(['id','name','parent_id'])
                    ->where(function ($query) use ($selectAll){
                        // 未删除
                        $query->where('status', 0);
                        if (!$selectAll) {
                            $query->where('type','enable');
                        }
                    })
                    ->get()
                    ->keyBy('id')
                    ->toArray();
        return $data;
    }

    public function visitTree($items, $ids = 0, $names = '')
    {
        // static $selection = array();
        static $selection = array(["id"=>0, "ids"=>"0", "names"=>"基础"]);
        $temp = array();
        foreach ($items as $key => $value) {
            if ($ids == 0) {
                $temp['id'] = $value['id'];
                $temp['ids'] = (string)$value['id'];
                $temp['names'] = $value['name'];
            } else {
                $temp['id'] = $value['id'];
                $temp['ids'] = $ids.'-'.$value['id'];
                $temp['names'] = $names.'>'.$value['name'];
            }
            array_push($selection, $temp);
            if (isset($value['children'])) {
                if ($ids == 0) {
                    $this->visitTree($items[$key]['children'], $value['id'], $value['name']);
                } else {
                    $this->visitTree($items[$key]['children'], $ids.'-'.$value['id'], $names.'>'.$value['name']);
                }
            }
        }
        
        return $selection;
    }

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
        $item = ServiceItems::select(['id','service_category_id','service_item_name','type','version','created_at','status'])
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
            $item = ServiceItems::where('status', 0)->find($params['id']);
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
            send_msg_json(ERROR_RETURN, "该服务项目不存在");
        }
        if ($item->version != $version) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        $item->type = $type;
        $item->version = $version+1;
        $item->save();
        // 返回信息
        $returnMsg = $type == 'enable' ? '启用成功' : '禁用成功';

        return $returnMsg;
    }

    /**
     * 获取分类列表
     *
     * @param [type] $params
     * @param integer $pageNumber
     * @return void
     */
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
                // 启用/禁用
                if ($params['type']) {
                    $query->where('type', $params['type']);
                }
            })
            ->paginate($pageNumber)
            ->toArray();
        return $list;
    }

    /**
     * 获取分类通过id
     *
     * @param int $id
     * @return void
     */
    public function getCategoryById($id)
    {
        $category = ServiceCategories::select(['id','name','parent_id','version','type','status'])
            ->where(['status'=>0,'id'=>$id])->first();
        if (empty($category)) {
            send_msg_json(ERROR_RETURN, "该服务分类不存在");
        }
        return $category;
    }

    /**
     * 创建/编辑分类
     *
     * @param [type] $params
     * @return void
     */
    public function saveCategory($params)
    {
        $returnMsg = '';
        if (empty($params['id'])) {
            $category = new ServiceCategories;
            $returnMsg = '添加成功';
        } else {
            $category = ServiceCategories::where('status', 0)->find($params['id']);
            if (empty($category)) {
                send_msg_json(ERROR_RETURN, "该服务分类不存在");
            }
            if ($category->version != $params['version']) {
                send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
            }
            // 版本号+1
            $category->version = $params['version']+1;
            // 返回信息
            $returnMsg = '编辑成功';
        }
        // 服务分类id
        $category->parent_id = $params['parent_id'];
        // 服务分类名
        $category->name = $params['name'];
        // 启用/禁用
        $category->type = $params['type'];

        DB::transaction(function () use ($category, $params) {
            // 保存
            $category->save();
            // 获取所有分类
            $categories = $this->getCategoryForTree();
            // 生成树
            $tree = getTree($categories, false);
            // 需要改变状态的树
            $changeTree = filterTreeById($tree, $category->id);
            // 需要改变状态的id集合
            $changeIds = getFilterIds($changeTree);
            // 判断状态格式
            $returnMsg = $this->changeCategoryType($changeIds, $params['type'], $category->version);
        });

        return array(
            'returnMsg'=>$returnMsg,
            'categoryId'=>$category->id
        );
    }

    /**
     * 启用/禁用服务分类
     *
     * @param [type] $id
     * @param [type] $type
     * @param [type] $version
     * @return void
     */
    public function changeCategoryType($changeIds, $type, $version)
    {
        // 启用/禁用所有节点分类
        DB::table('service_categories')->where('status', 0)->whereIn('id', $changeIds)->update(['type'=>$type, 'version'=>$version+1]);
        // 返回信息
        $returnMsg = $type == 'enable' ? '启用成功' : '禁用成功';

        return $returnMsg;
    }

    public function checkSameName($name, $id)
    {
        $count = ServiceCategories::where(['name'=>$name, 'status'=>0])->where('id','!=',$id)->count();

        if (empty($count)) {
            return false;
        } else {
            return true;
        }
    }
}
