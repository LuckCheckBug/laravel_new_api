<?php


namespace App\Http\Middleware;


use App\Exceptions\PermissionException;
use App\Exceptions\TokenException;
use App\Model\Permission;
use App\Model\Role;
use App\User;
use Closure;
use Illuminate\Http\Request;

class PermissionAuth
{
    public function handle(Request $request,Closure $next){
        $roleIds = User::getRoleId();
        $count = Role::query()->whereIn('id',$roleIds)->where(['type'=>0])->count('id');
        //超级管理员有所有权限
        if($count>0){
            return $next($request);
        }

        //如果数据库中没有Permission没有配置则 全部都有权限。
        $where = [['action','=',$request->route()->uri],['method','=',strtoupper($request->getMethod())]];
        $res = Permission::query()
            ->leftJoin('role_permission as rp','permission.id','=','rp.permission_id')
            ->where($where)->select(['role_id'])->first();
        if(empty($res)){
            return $next($request);
        }
        if(is_null($res->role_id)){
            throw new PermissionException("你没有操作权限");
        }
        if(!empty($res) && !in_array($res->role_id,$roleIds)){
            throw new PermissionException("你没有操作权限");
        }
        return $next($request);
    }

}
