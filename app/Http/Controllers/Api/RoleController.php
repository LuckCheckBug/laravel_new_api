<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Requests\RoleRequest;
use App\Model\Role;

class RoleController extends ApiController
{
    //构造函数
    public function __construct(RoleRequest $request)
    {
        parent::__construct($request);
    }

    //获取角色列表(分页)
    public function getRoleList(){
        $param = $this->param;
        $where = [];
        if(isset($param['roleName'])){
            $where []= ['name','like',"%{$param['roleName']}%"];
        }
        $page = $param['page']??1;
        $perPage = $param['perPage']??20;
        $data = Role::getRoleList($where,$perPage,$page);
        return $this->ajaxReturn(E_SUCCESS,'',$data);
    }

    //添加角色名称
    public function addRole(){
       $param =  request(['name']);
       $param['created_at'] = date("Y-m-d H:i:s");
       $param['updated_at'] = date("Y-m-d H:i:s");
       $bool = Role::addRole($param);
        return $this->boolReturn($bool);
    }

    //删除角色
    public function delRole(){
        $role_id = request('role_id');
        $bool = Role::delRole($role_id);
        return $this->boolReturn($bool,'delete');
    }

    //修改角色名称
    public function updateRole(){
        $param = $this->param;
        $data  = ['name'=>$param['name']];
        $bool  = Role::updateRole($param['role_id'],$data);
        return $this->boolReturn($bool,'update');
    }

    //获取所有角色名用于绑定用户
    public function getAllRole(){
        $data = Role::getAllRole();
        return $this->ajaxReturn(E_SUCCESS,'',$data);
    }


}
