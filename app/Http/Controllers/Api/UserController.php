<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Logic\UserLogic;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{


    public function __construct(UserRequest $request)
    {
        parent::__construct($request);
    }

    //获取用户列表
    public function getUserList(){
        $param = $this->param;
        $where = [];
        if(isset($param['name'])){
            $where []= ['name','like',"%{$param['name']}%"];
        }
        if(isset($param['email'])){
            $where []= ['email','=',$param['email']];
        }
        $perPage = $param['perPage']??20;
        $page    = $param['page']??1;
        $list    = User::UserList($where,$perPage,$page);
        return $this->ajaxReturn(E_SUCCESS,"",$list);
    }

    //添加账号（必须要登录过后才能注册）
    public function register(){
        $credentials = request(['name', 'email', 'password']);
        $credentials['password'] = Hash::make($credentials['password']);
        $bool    = User::register($credentials);
        return $this->boolReturn($bool);
    }

    //重置密码
    public function resetPassword(){
       $userId =  $this->param['id'];
       $res = User::resetPassword($userId);
       return $this->boolReturn($res,'update');
    }

}
