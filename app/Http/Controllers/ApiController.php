<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Jobs\WriteLogQueue;
use App\Logic\AjaxReturnLogic;
use App\Logic\PushQueueLogic;
use App\Service\AjaxReturnService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ApiController extends Controller
{
    public $request;
    public $param;
    public $requestTime;
    public $userInfo;

    public $boolMessage = [
        'create'=>['添加成功','添加失败'],
        'update'=>['修改成功','修改失败'],
        'delete'=>['删除成功','删除失败'],
        'bind'  =>['绑定成功','绑定失败'],
    ];

    /**
     * //构造参数 注入
     * ApiController constructor.
     * @param  $request
     */
    public function __construct($request){
        $this->userInfo = json_decode(json_encode(auth('api')->user()),true);
        $this->request  = $request;
        $this->param    = $request->all();
        if(isset($this->param['token'])){
            unset($this->param['token']);
        }
        $this->requestTime = time();
    }

    /**
     * 返回方法
     * @param int $code
     * @param string $message
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxReturn(int $code,$message='',$data=array(),$status=S_SUCCESS){
        //构造返回参数
        $result = [
            'errorCode'=>$code,
            'errorMessage'=>$message==''?ERROR_MESSAGE_LIST[$code]??ERROR_MESSAGE_LIST[E_UNKNOWN]:$message,
            'data'=>$data
        ];
        $ajaxReturn = new AjaxReturnService($this->request,$result,$this->requestTime);
        return $ajaxReturn->ajaxReturn()->json($result,$status);
    }

    //增删改的返回
    public function boolReturn($bool,$action='create'){
        $code    = $bool===false?E_FAILED:E_SUCCESS;
        $message = $bool===false?$this->boolMessage[$action][1]:$this->boolMessage[$action][0];
        return $this->ajaxReturn($code,$message);
    }







}
