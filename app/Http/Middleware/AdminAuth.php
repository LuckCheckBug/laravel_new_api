<?php
/*
 * @Author: your name
 * @Date: 2020-04-27 18:54:40
 * @LastEditTime: 2020-09-10 17:05:40
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: /Work/i-admin-manage-pc-interface/app/Http/Middleware/AdminAuth.php
 */

namespace App\Http\Middleware;

use App\Exceptions\RequestException;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTGuard;
use Illuminate\Support\Facades\DB;

class AdminAuth
{
    private $request;
    private $jWTGuard;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
     * @throws TokenException
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = auth()->guard('api')->user();

        //记录访问日志
        $route = $this->request->route()->getAction();
        $ip =
        $data = $this->request->all();
        unset($data['token']);


        var_dump(json_encode($user));
        //解决异常情况，jwt底层获取 token错误的问题
        if (!$user) {
            throw new RequestException('无效的令牌');
        }

        if ($user->status == 0) {
            throw new RequestException('该用户已被禁用');
        }

        if (! is_null($user->deteled_at)) {
            throw new RequestException('该用户已被删除');
        }

        if(!isset($route['as']) && empty($route['as'])){
            throw new \Exception('添加路由的时候，记得带上别名');
        }



        return $next($request);

    }

    public function getModuleMame($as){
        return '';
    }
}
