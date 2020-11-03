<?php

namespace App\Http\Requests;

use App\Exceptions\RequestException;
use App\Exceptions\TokenException;
use App\Service\AjaxReturnService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\JWTAuth;

class ApiBaseRequest extends FormRequest
{

    //开启验证
    public function authorize()
    {
        return true;
    }

    //错误回调函数
    public function failedValidation(Validator $validator)
    {

        $errorData = $validator->getMessageBag()->toArray();
        $string = '';
        foreach ($errorData as $val){
            $string .= $val[0].',';
        }
        $string  =  rtrim ( $string ,  "," );
        $user = auth('api')->user();
        if(empty($user) || !$user){
            throw new TokenException("无效TOKEN");
        }
        throw new RequestException($string);
    }

    //字段翻译
    public function attributes()
    {
        return [
            'name'=>"名称",
            'password'=>"用户密码",
            'email'=>"邮箱地址",
        ];
    }
}
