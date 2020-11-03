<?php

//定义常用的错误变量
define('E_SUCCESS',1000);

define('E_SYSTEM_ERROR',1001);

define('E_MYSQL_ERROR',1002);

define('E_FAILED',1003);

define("E_PARAM_ERROR",1004);

define("E_UNKNOWN",1005);

define("E_TIME_OUT",1006);

define("E_REQUEST_FAILED",1007);

define("E_PERMISSION_ERROR",1008);

define("E_NOT_FOUND_HTTP",1009);

define("E_TOKEN_EX",1011);
define("E_TOKEN_IN",1012);
define("E_TOKEN_NO",1013);
define("E_TOKEN_LO",1014);
define("E_TOKEN_AUTH",1015);


//全局文件错误信息
define("ERROR_MESSAGE_LIST",[
    1000=>"请求成功",
    1001=>"系统错误",
    1002=>"数据库异常",
    1003=>"系统异常",
    1004=>"参数错误",
    1005=>"未知错误",
    1006=>"请求超时",
    1007=>"请求验证失败",
    1008=>"无操作权限",
    1009=>"输入地址有误",
    //jwt登录的t错误码
    1011=>"Token已过期",
    1012=>"Token无效",
    1013=>"没有Token",
    1014=>"还未登录",
    1015=>"无访问权限",
]);

//http状态码
define("S_SUCCESS",200);

define("S_NOT_FOUND",404);

define("S_SYSTEM_ERROR",500);

define("S_MYSQL_ERROR",502);


//redis键值

define("QY_WX_TOKEN",'qywx_access_token');

