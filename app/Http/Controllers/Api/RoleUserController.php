<?php


namespace App\Http\Controllers\Api;


use App\Exceptions\ApiException;
use App\Http\Controllers\ApiController;
use App\Http\Requests\RoleUserRequest;
use App\Model\UserRole;
use Illuminate\Support\Facades\DB;

class RoleUserController extends ApiController
{
    public function __construct(RoleUserRequest $request)
    {
        parent::__construct($request);
    }

    //用户绑定角色
    public function bindRoleUser(){
        $param = $this->param;
        $userId  = $param['user_id'];
        $roleIds = $param['role_ids'];
        $bool = DB::transaction(function () use ($userId,$roleIds){
            UserRole::delRoleUser($userId);
            foreach ($roleIds as $roleId){
                $ins['role_id'] = $roleId;
                $ins['user_id'] = $userId;
                $ins['created_at'] = date("Y-m-d H:i:s");
                $ins['updated_at'] = date("Y-m-d H:i:s");
                $bool = UserRole::bindRoleUser($ins);
                if ($bool === false){
                    throw new ApiException('绑定失败');
                }
            }
            return true;
        });
        return $this->ajaxReturn($bool,'bind');
    }

}
