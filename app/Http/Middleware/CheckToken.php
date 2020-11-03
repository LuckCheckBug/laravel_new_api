<?php


namespace App\Http\Middleware;


use App\Exceptions\ApiException;
use App\Exceptions\RequestException;
use App\Exceptions\TokenException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class CheckToken extends BaseMiddleware
{

    public function handle(Request $request, Closure $closure){

       $this->checkForToken($request);
       if($this->auth->parseToken()->authenticate()) {
           $next = $closure($request);
           $user = auth('api')->user();
           if ($user->status == 0) {
               throw new TokenException('该用户已被禁用');
           }
           return $next;
       }
       throw new UnauthorizedHttpException('jwt-auth', '未登录,请先登录');
    }


}
