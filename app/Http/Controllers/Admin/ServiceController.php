<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\ServiceService;

class ServiceController extends Controller
{
    /**
     * 服务项目列表
     *
     * @param Request $request
     * @return string
     */
    public function getItemList(Request $request)
    {
        $serviceService = new ServiceService;
        // 服务分类id
        $params['service_category_id'] = (int)trim($request->input('service_category_id', 0));
        // 服务项目名
        $params['service_item_name'] = $request->input('service_item_name', '');
        // 一页几条，默认15条
        $pageNumber = (int)trim($request->input('pageNumber', 15));

        $list = $serviceService->getItemList($params, $pageNumber);

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
        $serviceService = new ServiceService;
        // 商品id
        $id = (int)trim($request->input('id', 0));
        // 判断id
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入id");
        }
        $item = $serviceService->getItemById($id);

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
        $serviceService = new ServiceService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken',''));

        $params['id'] = (int)trim($request->input('id', 0));

        $params['service_category_id'] = (int)trim($request->input('service_category_id', 0));

        $params['service_item_name'] = $request->input('service_item_name', '');

        $params['version'] = (int)trim($request->input('version', 0));
        if (empty($params['service_category_id'])) {
            send_msg_json(ERROR_RETURN, "请选择服务类别");
        }
        if ($params['service_item_name'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务名称");
        }
        // 保存服务项目
        $return = $serviceService->saveItem($params);
        // 编写操作日志
        if (empty($params['id'])) {
            $logMsg = "添加服务项目，操作id为：".$return['itemId'];
        } else {
            $logMsg = "编辑服务项目，操作id为：".$return['itemId'];
        }
        // 写入日志
        write_log($accessToken, $logMsg);
        return send_msg_json(SUCCESS_RETURN, $return['returnMsg']);
    }

    /**
     * 删除服务项目
     *
     * @param Request $request
     * @return void
     */
    public function deleteItem(Request $request)
    {
        $serviceService = new ServiceService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken', ''));
        // 服务项目id
        $id = (int)trim($request->input('id', 0));
        // 操作版本号
        $version = (int)trim($request->input('version', 0));
        // 判断id
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入id");
        }
        $serviceService->deleteItem($id, $version);
        // 写入日志
        write_log($accessToken, "删除服务人员，操作id为：".$id);

        return send_msg_json(SUCCESS_RETURN, "删除成功");
    }

    /**
     * 启用/禁用服务项目
     *
     * @param Request $request
     * @return void
     */
    public function changeItemType(Request $request)
    {
        $serviceService = new ServiceService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken', ''));
        // 服务项目id
        $id = (int)trim($request->input('id', 0));
        // 启用/禁用状态
        $type = trim($request->input('type', ''));
        // 操作版本号
        $version = (int)trim($request->input('version', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入服务分类id");
        }
        // 判断状态格式
        if (!in_array($type, array('enable','disable'))) {
            send_msg_json(ERROR_RETURN, "状态格式错误");
        }

        $returnMsg = $serviceService->changeItemType($id, $type, $version);
        // 编写日志
        if ($type == 'enable') {
            $logMsg = "启用服务分类，操作id为：".$id;
        } else if ($type == 'disable') {
            $logMsg = "停用服务分类，操作id为：".$id;
        }
        // 写入日志
        write_log($accessToken, $logMsg);

        return send_msg_json(SUCCESS_RETURN, $returnMsg);
    }

    /**
     * 服务分类列表
     *
     * @param Request $request
     * @return string
     */
    public function getCategoryList(Request $request)
    {
        $serviceService = new ServiceService;
        // 服务项目名
        $params['name'] = trim($request->input('name', ''));
        // 启用/禁用
        $params['type'] = trim($request->input('type', ''));
        // 一页几条，默认15条
        $pageNumber = (int)trim($request->input('pageNumber', 15));

        $list = $serviceService->getCategoryList($params, $pageNumber);

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }

    /**
     * 获取服务分类
     *
     * @param Request $request
     * @return void
     */
    public function getCategory(Request $request)
    {
        $serviceService = new ServiceService;
        // 分类id
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            $method = 'add';
            $category = array();
        } else {
            $method = 'edit';
            // 根据id获取服务分类
            $category = $serviceService->getCategoryById($id)->toArray();
        }
        // 所有服务分类
        $categories = $serviceService->getCategoryForTree();
        // 生成树结构
        $tree = getTree($categories, false);
        // 生成下拉菜单数据
        $selection = $serviceService->visitTree($tree);

        $data = array(
            'method' => $method,
            'category' => $category,
            'selection' => $selection
        );

        return send_msg_json(SUCCESS_RETURN, "success", $data);
    }

    /**
     * 编辑分类
     *
     * @param Request $request
     * @return void
     */
    public function editCategory(Request $request)
    {
        $serviceService = new ServiceService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken',''));

        $params['id'] = (int)trim($request->input('id', 0));

        $params['parent_id'] = (int)trim($request->input('parent_id', 0));

        $params['name'] = trim($request->input('name', ''));
        // 启用/禁用状态
        $params['type'] = trim($request->input('type', ''));

        $params['version'] = (int)trim($request->input('version', 0));
        
        if ($params['name'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务分类名");
        }
        if (!in_array($params['type'], array('enable','disable'))) {
            send_msg_json(ERROR_RETURN, "启用/禁用格式错误");
        }
        // 保存服务项目
        $return = $serviceService->saveCategory($params);
        // 编写操作日志
        if (empty($params['id'])) {
            $logMsg = "添加服务分类，操作id为：".$return['categoryId'];
        } else {
            $logMsg = "编辑服务分类，操作id为：".$return['categoryId'];
        }
        // 写入日志
        write_log($accessToken, $logMsg);
        return send_msg_json(SUCCESS_RETURN, $return['returnMsg']);
    }
    
    /**
     * 启用/禁用服务分类
     *
     * @param Request $request
     * @return void
     */
    public function changeCategoryType(Request $request)
    {
        $serviceService = new ServiceService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken', ''));
        // 服务分类id
        $id = (int)trim($request->input('id', 0));
        // 启用/禁用状态
        $type = trim($request->input('type', ''));
        // 操作版本号
        $version = (int)trim($request->input('version', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入服务分类id");
        }
        if (!in_array($type, array('enable','disable'))) {
            send_msg_json(ERROR_RETURN, "启用/禁用格式错误");
        }
        // 验证操作版本
        $category = $serviceService->getCategoryById($id);
        if ($category->version != $version) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        // 获取所有分类
        $categories = $serviceService->getCategoryForTree();
        // 生成树
        $tree = getTree($categories, false);
        // 需要改变状态的树
        $changeTree = filterTreeById($tree, $id);
        // 需要改变状态的id集合
        $changeIds = getFilterIds($changeTree);
        // 判断状态格式
        $returnMsg = $serviceService->changeCategoryType($changeIds, $type, $version);
        if ($type == 'enable') {
            $logMsg = "启用服务分类，操作id为：".$id;
        } else if ($type == 'disable') {
            $logMsg = "停用服务分类，操作id为：".$id;
        }
        // 写入日志
        write_log($accessToken, $logMsg);

        return send_msg_json(SUCCESS_RETURN, $returnMsg);
    }
}
