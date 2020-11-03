<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request as Req;

class AuthRequest extends ApiBaseRequest
{
    public function rules(Req $req){
        $route = $req->route()->getAction();
        $route['as'] = $route['as']??'';
        switch($route['as']){
            case "register":
                return [
                    'name' => 'required',
                    'password' => 'required|min:6|max:12',
                    'email'=>'required|email'
                ];
                break;
            case "password":
                return [
                    'password' => 'required|min:6|max:12',
                ];
                break;
            default:
                return [];
                break;
        }

    }

}
