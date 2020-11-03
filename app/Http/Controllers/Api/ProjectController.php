<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Requests\ProjectRequest;
use App\Model\Project;

class ProjectController extends ApiController
{
    public function __construct(ProjectRequest $request)
    {
        parent::__construct($request);
    }

    //项目列表
    public function getProjectList(){
        $data = Project::getProjectList();
        return $this->ajaxReturn(E_SUCCESS,'',$data);
    }

    //添加项目
    public function addProject(){
        $param = request(['project_name']);
        $bool  = Project::addProject($param);
        return $this->boolReturn($bool);
    }

}
