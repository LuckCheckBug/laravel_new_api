<?php


namespace App\Service;


use App\Exceptions\ApiException;

class SendRtxService
{
    private $corpId;

    private $corpSecret;

    private $agentId;

    private $accessTokenUrl = "https://qyapi.weixin.qq.com/cgi-bin/gettoken";

    private $sendMessageUrl = "https://qyapi.weixin.qq.com/cgi-bin/message/send";


    public function __construct($config=null){
        $config = $config==null?config('config.rtx'):$config;
        try {
            $this->corpId     = $config['corpId'];
            $this->corpSecret = $config['corpSecret'];
            $this->agentId    = $config['agentId'];
        }catch (\Exception $exception){
            throw new ApiException('配置文件错误',E_FAILED);
        }
    }

    //企业微信推送消息
    public function sendRtx($user="LiuZhenQiang",$message="测试测试测试"){
        $redis = RedisService::RedisConnection();
        $access_token = $redis->get(QY_WX_TOKEN);
        if(empty($access_token)){
            $access_token = $this->getAccessToken();
        }
        $url = $this->sendMessageUrl;
        $param = ['access_token'=>$access_token];
        $data  = [
            'touser' =>$user,
            'msgtype'=>'text',
            'agentid'=>$this->agentId,
            'text'   =>['content'=>$message],
        ];
        $json = json_encode($data);
        $url = $this->buildUrlParam($url,$param);
        $json = $this->curl($url,'post',$json);
        $data = json_decode($json,true);
        if($data['errcode'] != 0){
            //todo 发送失败(需要记录和发送邮件)
            return false;
        }
        return true;
    }

    //获取token
    private function getAccessToken(){
        $redis = RedisService::RedisConnection();
        $param = ['corpid'=>$this->corpId,'corpsecret'=>$this->corpSecret];
        $url   = $this->accessTokenUrl;
        $url   = $this->buildUrlParam($url,$param);
        $json  = $this->curl($url);
        $data  = json_decode($json,true);
        if($data['errcode'] != 0){
            throw new ApiException("获取企业微信Token失败",E_FAILED);
        }
        $accessToken = $data['access_token'];
        $redis->set(QY_WX_TOKEN,$accessToken);
        $redis->expire(QY_WX_TOKEN,7200);
        return $accessToken;
    }


    //cCurl请求
    private function curl($url,$type='get',$post=array()){
        $ch = curl_init();
        curl_setopt($ch , CURLOPT_HEADER, 0); //设置header
        curl_setopt($ch , CURLOPT_URL,$url);//设置访问的地址
        curl_setopt($ch , CURLOPT_RETURNTRANSFER,1);//获取的信息返回
        curl_setopt($ch , CURLOPT_SSL_VERIFYPEER, false);
        if($type == 'post'){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
        }
        $output = curl_exec($ch);//采集
        if(curl_error($ch)){
            return curl_error($ch);
        }
        return $output;
    }

    //构造url参数
    private function buildUrlParam($url,$param){
        if (!is_array($param)){
            return $url;
        }
        $paramString ='?';
        foreach ($param as $key=>$value){
            $string = $key.'='.$value."&";
            $paramString .= $string;
        }
        $paramString = substr($paramString,0,-1);
        return $url.$paramString;
    }

}
