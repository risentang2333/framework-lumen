<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\AbilityService;

class AbilityController extends Controller
{
    public function getAbilityList(Request $request)
    {
        $abilityService = new AbilityService;
        // 能力标签名
        $params['name'] = trim($request->input('name', ''));
        // 启用/禁用
        $params['type'] = trim($request->input('type', ''));
        // 一页几条，默认15条
        $pageNumber = (int)trim($request->input('pageNumber', 15));

        $list = $abilityService->getAbilityList($params, $pageNumber);

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }

    public function getAbility(Request $request)
    {
        $abilityService = new AbilityService;
        // 分类id
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            $method = 'add';
            $ability = array();
        } else {
            $method = 'edit';
            // 根据id获取服务分类
            $ability = $abilityService->getAbilityById($id)->toArray();
        }
        // 所有服务分类
        $abilities = $abilityService->getAbilityForTree();
        // 生成树结构
        $tree = getTree($abilities);
        // 生成下拉菜单数据
        $selection = $abilityService->visitTree($tree);

        $data = array(
            'method' => $method,
            'ability' => $ability,
            'selection' => $selection
        );

        return send_msg_json(SUCCESS_RETURN, "success", $data);
    }

    public function editAbility(Request $request)
    {
        $abilityService = new AbilityService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken',''));

        $params['id'] = (int)trim($request->input('id', 0));

        $params['parent_id'] = (int)trim($request->input('parent_id', 0));

        $params['name'] = trim($request->input('name', ''));

        $params['type'] = trim($request->input('type', ''));

        $params['version'] = (int)trim($request->input('version', 0));
        
        if ($params['name'] == '') {
            send_msg_json(ERROR_RETURN, "请填写服务分类名");
        }
        if (!in_array($params['type'], array('enable','disable'))) {
            send_msg_json(ERROR_RETURN, "启用/禁用格式错误");
        }
        // 保存服务项目
        $return = $abilityService->saveAbility($params);
        // 编写操作日志
        if (empty($params['id'])) {
            $logMsg = "添加能力标签，操作id为：".$return['abilityId'];
        } else {
            $logMsg = "编辑能力标签，操作id为：".$return['abilityId'];
        }
        // 写入日志
        write_log($accessToken, $logMsg);
        return send_msg_json(SUCCESS_RETURN, $return['returnMsg']);
    }

    public function changeAbilityType(Request $request)
    {
        $abilityService = new AbilityService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken', ''));
        // 能力标签id
        $id = (int)trim($request->input('id', 0));
        // 启用/禁用状态
        $type = trim($request->input('type', ''));
        // 操作版本号
        $version = (int)trim($request->input('version', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入能力标签id");
        }
        if (!in_array($type, array('enable','disable'))) {
            send_msg_json(ERROR_RETURN, "启用/禁用格式错误");
        }
        // 验证操作版本
        $ability = $abilityService->getAbilityById($id);
        if ($ability->version != $version) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        // 获取所有分类
        $abilities = $abilityService->getAbilityForTree();
        // 生成树
        $tree = getTree($abilities, false);
        // 需要改变状态的树
        $changeTree = filterTreeById($tree, $id);
        // 需要改变状态的id集合
        $changeIds = getFilterIds($changeTree);
        // 判断状态格式
        $returnMsg = $abilityService->changeAbilityType($changeIds, $type, $version);
        if ($type == 'enable') {
            $logMsg = "启用能力标签，操作id为：".$id;
        } else if ($type == 'disable') {
            $logMsg = "停用能力标签，操作id为：".$id;
        }
        // 写入日志
        write_log($accessToken, $logMsg);

        return send_msg_json(SUCCESS_RETURN, $returnMsg);
    }

    public function deleteAbility(Request $request)
    {
        $abilityService = new AbilityService;

        $accessToken = trim($request->header('accessToken', ''));
        // 删除id
        $id = (int)trim($request->input('id', 0));
        // 操作版本号
        $version = (int)trim($request->input('version', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入能力标签id");
        }
        // 验证操作版本
        $ability = $abilityService->getAbilityById($id);
        if ($ability->version != $version) {
            send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
        }
        $abilities = $abilityService->getAbilityForTree();
        // 获取所有权限树结构
        $tree = getTree($abilities, false);
        // 获取待删除的树
        $deleteTree = filterTreeById($tree, $id);
        // 获取待删除id
        $deleteIds = getFilterIds($deleteTree);
        // 删除权限
        $abilityService->deleteAbility($deleteIds, $version);

        write_log($accessToken, "删除成功，"."操作id为：".$id);

        return send_msg_json(SUCCESS_RETURN, "删除成功");
    }
}
