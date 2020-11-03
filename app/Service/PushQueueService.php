<?php


namespace App\Service;


use App\Exceptions\ApiException;

class PushQueueService
{
    /**
     * 入队列
     * @param $ObjService
     * @param $name
     * @throws ApiException
     */
    public static function pushQueue($ObjService,$name){

        if(empty($ObjService)||!is_object($ObjService)){
            throw new ApiException("入队列时传输对象出错",E_FAILED);
        }
        if(empty($name) || $name==''){
            throw new ApiException("队列名称不能为空",E_FAILED);
        }
        dispatch($ObjService->onQueue($name));
    }

}
