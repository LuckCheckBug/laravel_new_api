<?php


namespace App\Logic;


class WriteLogLogic
{
    //静态方法写log
    public static function saveLog($url,$method,$requestParam='',$responseParam='',$requestTime=0,$responseTime=0,$responseCode=0,$responseMessage='',$useTime=0,$userInfo=''){
        $writeContent = PHP_EOL."requestUri：".$url."  ".$method;
        if($requestTime>0){
            $writeContent .= "  ".date("Y-m-d H:i:s",$requestTime);
        }
        if($responseCode >0){
            $writeContent .= "  ".$responseCode;
        }
        if($responseMessage != ''){
            $writeContent .= "  ".$responseMessage;
        }
        $writeContent .=PHP_EOL;
        if($requestParam !=''){
            $writeContent .= "requestParam：".$requestParam.PHP_EOL;
        }
        if($responseParam != ''){
            $writeContent .= "responseParam：".$responseParam.PHP_EOL;
        }
        if($userInfo != '' || $userInfo !=null){
            $writeContent .= "userInfo：".$userInfo.PHP_EOL;
        }
        $writeContent .= "useTime(s)：".$useTime.PHP_EOL;
        self::writeLog($writeContent);
    }

    //把日志写入文件
    public static function writeLog($writeContent,$path= __DIR__.'/../../log/'){
        if(!is_dir($path)){
            mkdir($path,0777);
        }
        $filepath = $path.date("Ymd").'.log';
        file_put_contents($filepath,$writeContent,FILE_APPEND);
    }

    //把用户操作日志写入mysql
    public static function writeLogToMysql(){

    }


}
