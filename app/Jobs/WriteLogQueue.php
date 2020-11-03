<?php

namespace App\Jobs;

use App\Logic\WriteLogLogic;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mockery\Exception;

class WriteLogQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //请求时间 时间戳
    private $requestTime;
    //返回时间 时间戳
    private $responseTime;
    //请求的用户信息
    private $userInfo;
    //请求地址
    private $url;
    //请求参数
    private $requestParam;
    //返回CODE
    private $responseCode;
    //返回CODE信息
    private $responseMessage;
    //返回数据
    private $responseParam;
    //请求方法
    private $method;
    //请求用户
    private $user="暂无";
    //对的重试时间
    public $tries = 3;
    //超时时间
    public $timeout = 10;

    /**
     * 写日志构造参数
     * WriteLogQueue constructor.
     * @param $requestTime
     * @param $responseTime
     * @param $url
     * @param $requestParam
     * @param $responseCode
     * @param $responseMessage
     * @param $responseParam
     */
    public function __construct($requestTime,$responseTime,$userInfo,$url,$method,$requestParam,$responseCode,$responseMessage,$responseParam)
    {
        $this->requestTime      =  $requestTime;
        $this->responseTime     =  $responseTime;
        $this->userInfo         =  $userInfo;
        $this->url              =  $url;
        $this->requestParam     =  $requestParam;
        $this->responseCode     =  $responseCode;
        $this->responseMessage  =  $responseMessage;
        $this->responseParam    =  $responseParam;
        $this->method           =  $method;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        $useTime = abs($this->requestTime-$this->responseTime);
        //写日志
        WriteLogLogic::saveLog($this->url,$this->method,json_encode($this->requestParam),json_encode($this->responseParam),
            $this->requestTime,$this->responseTime,$this->responseCode, $this->responseMessage,$useTime,$this->userInfo);
    }

    //失败 写入失败发送邮件
    public function failed(\Exception $exception){
        var_dump($exception->getMessage());
    }



}
