<?php

namespace App\Services\Admin;

use App\Entities\ConfigAuthentications;
use App\Entities\ConfigCourses;
use App\Entities\ConfigPaperCategories;
use App\Entities\ConfigServiceCategories;
use App\Entities\ConfigServiceCrowds;
use App\Entities\ConfigServiceTypes;
use App\Entities\ConfigSources;
use App\Entities\ConfigWorkingAges;
use Illuminate\Support\Facades\DB;

class FormConfigService 
{    
    public function getFormConfig()
    {
        $data['authentication'] = ConfigAuthentications::select(['id','name','type','version'])->get();
        $data['course'] = ConfigCourses::select(['id','name','type','version'])->get();
        $data['paper_category'] = ConfigPaperCategories::select(['id','name','type','version'])->get();
        $data['service_category'] = ConfigServiceCategories::select(['id','name','type','version'])->get();
        $data['service_crowd'] = ConfigServiceCrowds::select(['id','name','type','version'])->get();
        $data['service_type'] = ConfigServiceTypes::select(['id','name','type','version'])->get();
        $data['source'] = ConfigSources::select(['id','name','type','version'])->get();
        $data['working_age'] = ConfigWorkingAges::select(['id','name','type','version'])->get();

        return $data;
    }

    public function editFormConfig($params)
    {
        $table = '';
        switch ($params['table']) {
            case 'authentication':
                $table = 'config_authentications';
                break;
            case 'course':
                $table = 'config_courses';
                break;
            case 'paper_category':
                $table = 'config_paper_categories';
                break;
            case 'service_category':
                $table = 'config_service_categories';
                break;
            case 'service_crowd':
                $table = 'config_service_crowds';
                break;
            case 'service_type':
                $table = 'config_service_types';
                break;
            case 'source':
                $table = 'config_sources';
                break;
            case 'working_age':
                $table = 'config_working_ages';
                break;
            default:
                send_msg_json(ERROR_RETURN, "请传入配置表信息");
                break;
        }
        if (DB::table($table)->where(['name'=>$params['name'],'id'=>$params['id']])->count() > 0) {
            send_msg_json(ERROR_RETURN, "参数名称重复");
        }
        if (empty($params['id'])) {
            return DB::table($table)->insert(['name'=>$params['name']]);
        } else {
            $option = DB::table($table)->select(['version'])->where('id',$params['id'])->first();
            if (empty($option)) {
                send_msg_json(ERROR_RETURN, "配置信息不存在");
            }
            if ($option->version != $params['version']) {
                send_msg_json(ERROR_RETURN, "数据错误，请刷新页面");
            }
            return DB::table($table)->where('id',$params['id'])->update(['name'=>$params['name'], 'type'=>$params['type'], 'version'=>$params['version']+1]);
        }
    }
}
