<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\CommonService;

class CommonController extends Controller
{
    /**
     * 获取地区列表
     *
     * @return string
     */
    public function getAreaTree()
    {
        $commonService = new CommonService;

        $areas = $commonService->getAreaForTree();

        $tree = getTree($areas);

        return send_msg_json(SUCCESS_RETURN, "success", $tree);
    }

    /**
     * 获取服务分类列表
     *
     * @return string
     */
    public function getServiceTree(Request $request)
    {
        $commonService = new CommonService;
        // 获取类型
        $type = trim($request->input('type', ''));

        $service = $commonService->getCategoryForTree($type);

        $tree = getTree($service);

        return send_msg_json(SUCCESS_RETURN, "success", $tree);
    }
    
    /**
     * 获取标签树结构
     *
     * @return string
     */
    public function getLabelTree(Request $request)
    {
        $commonService = new CommonService;
        // 获取类型
        $type = trim($request->input('type', ''));

        $label = $commonService->getLabelForTree($type);

        $tree = getTree($label);

        return send_msg_json(SUCCESS_RETURN, "success", $tree);
    }

    public function getPaperSelection(Request $request)
    {
        $commonService = new CommonService;
        // 获取类型
        $type = trim($request->input('type', ''));
        
        $selection = $commonService->getPaperSelection($type);

        return send_msg_json(SUCCESS_RETURN, "success", $selection);
    }

    public function uploadImage(Request $request)
    {
        $request = $request->all();
        $file = $request['file'];
        return send_msg_json(SUCCESS_RETURN, "success", file_upload($file));
    }
}
