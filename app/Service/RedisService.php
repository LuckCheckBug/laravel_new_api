<?php


namespace App\Service;


use Illuminate\Support\Facades\Redis;

class RedisService
{

    //单例
    private static $RedisServer =null;

    //私有化构造器
    private function __construct(){}

    //禁止clone
    private function __clone(){}


    public static function RedisConnection(string $name=null){
        if(self::$RedisServer == null){
            self::$RedisServer = Redis::connection($name);
        }
        return  self::$RedisServer;
    }

}
