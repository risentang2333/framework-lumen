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
    public function getServiceTree()
    {
        $commonService = new CommonService;

        $service = $commonService->getCategoryForTree();

        $tree = getTree($service);

        return send_msg_json(SUCCESS_RETURN, "success", $tree);
    }
    
    /**
     * 获取标签树结构
     *
     * @return string
     */
    public function getLabelTree()
    {
        $commonService = new CommonService;

        $label = $commonService->getLabelForTree();

        $tree = getTree($label);

        return send_msg_json(SUCCESS_RETURN, "success", $tree);
    }

    public function getPaperSelection()
    {
        $commonService = new CommonService;
        
        $selection = $commonService->getPaperSelection();

        return send_msg_json(SUCCESS_RETURN, "success", $selection);
    }
}
