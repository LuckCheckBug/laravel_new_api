<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Requests\AuthRequest;
use App\Logic\UserLogic;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function __construct(AuthRequest $request)
    {
        $this->middleware('api.auth', ['except' => ['login']]);
        parent::__construct($request);
    }

    //用户登录获取token
    public function login(){
        $credentials = request(['email', 'password']);
        if (! $token = auth('api')->attempt($credentials)) {
            return $this->ajaxReturn(E_FAILED,'登录错误',[],401);
        }
        return $this->respondWithToken($token);
    }

    //获取当前用户的信息
    public function me(){
        return $this->ajaxReturn(E_SUCCESS,"",$this->userInfo);
    }

    //推出登录
    public function logout(){
        auth('api')->logout();
        return $this->ajaxReturn(E_SUCCESS,"退出成功");
    }

    //修改密码
    public function changePassword(){
        $password = request(['password']);
        $id      = $this->userInfo['id'];
        $res     = User::query()->where(['id'=>$id])->update(['password'=>Hash::make($password['password'])]);
        return $this->boolReturn($res,'update');
    }

    //刷新token
    public function refresh(){
        return $this->respondWithToken(auth('api')->refresh());
    }



    //返回token
    protected function respondWithToken($token)
    {
        return $this->ajaxReturn(E_SUCCESS,'获取成功',[
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60 * 12
        ]);
    }

}
