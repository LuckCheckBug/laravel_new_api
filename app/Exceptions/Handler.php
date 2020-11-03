<?php

namespace App\Exceptions;

use App\Common\Http\Response;
use App\Service\AjaxReturnService;
use Cassandra\Exception\TimeoutException;
use Doctrine\DBAL\Driver\PDOException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {

        //手动抛出的异常
        if($exception instanceof ApiException){
            $result = [
                'errorCode'=>$exception->getCode()==0?E_FAILED:$exception->getCode(),
                'errorMessage'=>$exception->getMessage()==''?ERROR_MESSAGE_LIST[$exception->getCode()]
                    ??ERROR_MESSAGE_LIST[E_UNKNOWN]:$exception->getMessage(),
                'data'=>array()
            ];
            $status = S_SUCCESS;

        }
        elseif ($exception instanceof PDOException){
            $result = [
                'errorCode'=>E_MYSQL_ERROR,
                'errorMessage'=>ERROR_MESSAGE_LIST[E_MYSQL_ERROR],
                'data'=>false
            ];
            $status = S_SYSTEM_ERROR;

        }
        elseif ($exception instanceof NotFoundHttpException){
            $result = [
                'errorCode'=>E_NOT_FOUND_HTTP,
                'errorMessage'=>ERROR_MESSAGE_LIST[E_NOT_FOUND_HTTP],
                'data'=>false
            ];
            $status = S_NOT_FOUND;

        }
        //JWT异常
        elseif ($exception instanceof TokenInvalidException){

            $result = [
                'errorCode'=>E_TOKEN_IN,
                'errorMessage'=>ERROR_MESSAGE_LIST[E_TOKEN_IN],
                'data'=>false
            ];
            $status = S_SYSTEM_ERROR;
        }elseif ($exception instanceof TokenExpiredException){
            $result = [
                'errorCode'=>E_TOKEN_EX,
                'errorMessage'=>ERROR_MESSAGE_LIST[E_TOKEN_EX],
                'data'=>false
            ];
            $status =S_SYSTEM_ERROR;
        }elseif ($exception instanceof JWTException){
            $result = [
                'errorCode'=>E_TOKEN_NO,
                'errorMessage'=>ERROR_MESSAGE_LIST[E_TOKEN_NO],
                'data'=>false
            ];
            $status =S_SYSTEM_ERROR;
        }
        elseif ($exception instanceof UnauthorizedHttpException){
            $result = [
                'errorCode'=>E_TOKEN_LO,
                'errorMessage'=>ERROR_MESSAGE_LIST[E_TOKEN_LO],
                'data'=>false
            ];
            $status =S_NOT_FOUND;
        }
        //JWT异常结束

       /* //超市异常
        elseif ($exception instanceof Time){
            $result = [
                'errorCode'=>E_TIME_OUT,
                'errorMessage'=>ERROR_MESSAGE_LIST[E_TIME_OUT],
                'data'=>false
            ];
            $status =S_SYSTEM_ERROR;
        }*/
        //请求验证异常
        elseif ($exception instanceof RequestException){
            $result = [
                'errorCode'=>E_FAILED,
                'errorMessage'=>$exception->getMessage(),
                'data'=>false
            ];
            $status =S_SUCCESS;
        }
        //手动TOKEN异常
        elseif ($exception instanceof TokenException){
            $result = [
                'errorCode'=>E_TOKEN_IN,
                'errorMessage'=>$exception->getMessage(),
                'data'=>false
            ];
            $status =S_SYSTEM_ERROR;
        }
        //权限异常
        elseif ($exception instanceof PermissionException){
            $result = [
                'errorCode'=>E_PERMISSION_ERROR,
                'errorMessage'=>$exception->getMessage(),
                'data'=>false
            ];
            $status =S_SYSTEM_ERROR;
        }
        else{
            $result = [
                'errorCode'=>E_UNKNOWN,
                //'errorMessage'=>ERROR_MESSAGE_LIST[E_UNKNOWN],
                'errorMessage'=>$exception->getMessage().$exception->getFile().$exception->getLine(),
                'data'=>false
            ];
            $status =S_SYSTEM_ERROR;
        }
        return (new AjaxReturnService($request,$result,time()))->ajaxReturn()->json($result,$status);
        //todo 这里的异常需要发邮件
        //return parent::render($request, $exception);
    }
}
