<?php


namespace App\Service;


use App\Jobs\WriteLogQueue;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class AjaxReturnService
{
    //请求参数对象 Request
    private $request;
    //请求时间
    private $requestTime;
    //返回参数
    private $response;

    /**
     * AjaxReturnLogic constructor.
     * @param Request $request
     * @param $response
     * @param $requestTime
     */
    public function __construct(Request $request,$response,$requestTime){
        $this->request = $request;
        $this->requestTime = $requestTime;
        $this->response = $response;
    }

    //重新构造的ajax返回
    public  function ajaxReturn($content = '', $status = 200, array $headers = []){

        $factory = app(ResponseFactory::class);
        if (func_num_args() === 0) {
            return $factory;
        }
        return $factory->make($content, $status, $headers);
    }

    //把日志入队列
    private function writeLog(){
        $url             = explode('?',$this->request->getRequestUri())[0]??$this->request->getRequestUri();
        $responseTime    = time();
        $requestTime     = $this->requestTime;
        $all             = $this->request->all();
        //处理文件  消息队列里面不能存对象
        foreach ($all as $k=>$value){
            if($value instanceof UploadedFile){
                $all[$k] = "file";
            }
        }
        $requestParam    = $all;
        $responseParam   = $this->response['data']??false;
        $responseMessage = $this->response['errorMessage']??"";
        $responseCode    = $this->response['errorCode']??"";
        $method          = $this->request->getMethod();
        $userInfo = json_encode(auth('api')->user());

        //入队列  队列名字writelog  监听队列  php artisan queue:work --queue=writelog
        $writeLogService = new WriteLogQueue($requestTime,$responseTime,$userInfo,$url,$method,$requestParam,$responseCode,
            $responseMessage,$responseParam);
        PushQueueService::pushQueue($writeLogService,"writelog");
    }

    //析构函数写日志
    public function __destruct(){
        $this->writeLog();
    }

}
