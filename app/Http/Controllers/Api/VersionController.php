<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Requests\VersionRequest;
use App\Model\Version;

class VersionController extends ApiController
{
    public function __construct(VersionRequest $request)
    {
        parent::__construct($request);
    }

    //添加版本
    public function addVersion(){
        $param = request(['project_id','version_name']);
        $bool  = Version::addVersion($param);
        return $this->boolReturn($bool);
    }

    //获取版本列表
    public function getVersionList(){
        $where = request(['project_id']);
        $data  = Version::getVersionList($where);
        return $this->ajaxReturn(E_SUCCESS,'',$data);
    }

}
