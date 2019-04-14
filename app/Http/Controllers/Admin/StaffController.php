<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\Admin\StaffService;

class StaffController extends Controller
{
    /**
     * 获取工作人员列表
     *
     * @param Request $request
     * @return string
     */
    public function getStaffList(Request $request)
    {
        $staffService = new StaffService;
        // 获取为了哪个模块
        $params['get_for'] = trim($request->input('get_for','staff'));
        // 服务人员姓名
        $params['name'] = trim($request->input('name',''));
        // 手机号
        $params['phone'] = trim($request->input('phone',''));
        // 员工号
        $params['staff_code'] = trim($request->input('staff_code',''));
        // 服务分类id
        $params['service_category_id'] = (int)trim($request->input('service_category_id', 0));
        // 能力标签id集合
        $params['service_crowd_ids'] = $request->input('service_crowd_ids', array());
        // 服务地址id集合
        $params['region_ids'] = $request->input('region_ids', array());
        // 根据证件类型查询
        $params['paper_ids'] = $request->input('paper_ids', array());
        // 懒加载分页用
        if ($request->input('lastId')) {
            $params['lastId'] = (int)trim($request->input('lastId', 0));
        }
        // 返回格式，lazyLoad懒加载，paginate列表分页
        $format = trim($request->input('format', 'paginate'));
        // 一页几条，默认15条
        $pageNumber = (int)trim($request->input('pageNumber', 15));

        $list = $staffService->getStaffList($params, $format, $pageNumber);
        if (!empty($list['data'])) {
            array_walk($list['data'], function (&$item){
                if (!empty($item['register_at'])) {
                    $item['register_at'] = $item['register_at'] * 1000;
                }
                if (!empty($item['created_at'])) {
                    $item['created_at'] = $item['created_at'] * 1000;
                }
            });
        }

        return send_msg_json(SUCCESS_RETURN, "success", $list);
    }

    /**
     * 获取服务人员信息
     *
     * @param Request $request
     * @return string
     */
    public function getStaff(Request $request)
    {
        $staffService = new StaffService;
        // 工作人员id
        $id = (int)trim($request->input('id', 0));
        if (empty($id)) {
            send_msg_json(ERROR_RETURN, "请传入服务人员id");
        }
        // 工作人员信息
        $staff = $staffService->getStaffById($id);

        $staff['course'] = $staffService->getCourseById($id);
        $staff['paper'] = $staffService->getPaperById($id);
        $staff['photo'] = $staffService->getPhotoById($id);
        $staff['region'] = $staffService->getRegionById($id);
        $staff['service_crowd'] = $staffService->getServiceCrowdsById($id);
        $staff['service_type'] = $staffService->getServiceTypesById($id);
        $staff['skill'] = $staffService->getSkillById($id);
        $staff['certificate'] = $staffService->getCertificateById($id);
        
        return send_msg_json(SUCCESS_RETURN, "success", $staff);
    }

    /**
     * 编辑/添加服务人员
     *
     * @param Request $request
     * @return string
     */
    public function editStaff(Request $request)
    {
        $staffService = new StaffService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken',''));
        // 服务人员id
        $params['id'] = (int)trim($request->input('id', 0));
        // 登记时间
        $params['register_at'] = (int)trim($request->input('register_at', 0));
        // 认证状态
        $params['authentication'] = (int)trim($request->input('authentication', 0));
        // 服务人员姓名
        $params['name'] = trim($request->input('name', ''));
        // 年龄
        $params['age'] = (int)trim($request->input('age', 0));
        // 服务人员手机号
        $params['phone'] = trim($request->input('phone', ''));
        // 回访信息
        $params['return_msg'] = trim($request->input('return_msg', ''));
        // 接单状态
        $params['working_status'] = (int)trim($request->input('working_status', 0));
        // 备注
        $params['remarks'] = trim($request->input('remarks', ''));
        // 工龄
        $params['working_age'] = (int)trim($request->input('working_age', 0));
        // 工作经验
        $params['working_experience'] = trim($request->input('working_experience', ''));
        // 民族
        $params['nation'] = trim($request->input('nation', ''));
        // 籍贯
        $params['birthplace'] = trim($request->input('birthplace', ''));
        // 身份证号
        $params['identify'] = trim($request->input('identify', ''));
        // 住址
        $params['address'] = trim($request->input('address', ''));
        // 教育程度
        $params['education'] = (int)trim($request->input('education', 0));
        // 紧急联系人
        $params['urgent_phone'] = trim($request->input('urgent_phone', ''));
        // 银行卡号
        $params['bank_card'] = trim($request->input('bank_card', ''));
        // 服务人员头像
        $params['icon'] = trim($request->input('icon', ''));
        // 信息来源
        $params['source'] = (int)trim($request->input('source', 0));
        // 服务人员性别
        $params['sex'] = (int)trim($request->input('sex', 1));
        // 操作版本号
        $params['version'] = (int)trim($request->input('version', 0));
        // 培训课程（数组）
        $params['course'] = $request->input('course', array());
        // 证书（数组）
        $params['paper'] = $request->input('paper', array());
        // 照片（数组）
        $params['photo'] = $request->input('photo', array());
        // 服务地区（数组）
        $params['region'] = $request->input('region', array());
        // 服务人群标签（数组）
        $params['service_crowd'] = $request->input('service_crowd', array());
        // 服务类型标签（数组）
        $params['service_type'] = $request->input('service_type', array());
        // 技能（数组）
        $params['skill'] = $request->input('skill', array());

        $params['certificate'] = $request->input('certificate', array());
        // if ($params['name'] == '') {
        //     send_msg_json(ERROR_RETURN, "请填写服务人员姓名");
        // }
        // if ($params['phone'] == '') {
        //     send_msg_json(ERROR_RETURN, "请填写服务人员手机");
        // }
        // // 身份证号
        // if ($params['identify'] == '') {
        //     send_msg_json(ERROR_RETURN, "请填写服务人员身份证号");
        // }
        // if (!verify_identity($params['identify'])) {
        //     send_msg_json(ERROR_RETURN, "身份证号格式错误");
        // }
        // // 验证手机号格式
        // if (!verify_phone($params['phone'])) {
        //     send_msg_json(ERROR_RETURN, "手机号格式错误");
        // }
        // if ($params['address'] == '') {
        //     send_msg_json(ERROR_RETURN, "请填写服务人员现住址");
        // }
        // if ($params['bank_card'] == '') {
        //     send_msg_json(ERROR_RETURN, "请填写银行卡号");
        // }
        // // 验证银行卡号
        // if (!verify_bank_card($params['bank_card'])) {
        //     send_msg_json(ERROR_RETURN, "银行卡号格式错误");
        // }
        // if (empty($params['age'])) {
        //     send_msg_json(ERROR_RETURN, "请填写服务人员年龄");
        // }
        $return = $staffService->saveStaff($params, $accessToken);
        
        // 编写操作日志
        if (empty($params['id'])) {
            $logMsg = "添加员工信息，操作id为：".$return['staffId'];
        } else {
            $logMsg = "编辑员工信息，操作id为：".$return['staffId'];
        }
        // 写入日志
        write_log($accessToken, $logMsg);

        return send_msg_json(SUCCESS_RETURN, $return['returnMsg']);
    }

    /**
     * 停用/启用服务人员
     *
     * @param Request $request
     * @return string
     */
    public function changeStaffStatus(Request $request)
    {
        $staffService = new StaffService;
        // 访问令牌
        $accessToken = trim($request->header('accessToken', ''));
        // 服务人员id
        $id = (int)trim($request->input('id', 0));
        // 操作版本号
        $version = (int)trim($request->input('version', 0));

        $returnMsg = $staffService->changeStaffStatus($id, $version,$accessToken);

        return send_msg_json(SUCCESS_RETURN, $returnMsg);
    }

    public function checkStaffName(Request $request)
    {
        $staffService = new StaffService;
        // 服务人员id
        $id = (int)trim($request->input('id', 0));
        // 服务人员姓名
        $name = trim($request->input('name', ''));

        if ($name == '') {
            send_msg_json(ERROR_RETURN, "请输入姓名");
        }

        $result = $staffService->checkStaffName($id, $name);
        if ($result['isRepeat'] == 1) {
            send_msg_json(ERROR_RETURN, "该姓名已重复", $result);
        } else {
            return send_msg_json(SUCCESS_RETURN, '不重复');
        }
    }
}
