<?php


namespace App\Http\Requests;


use Illuminate\Http\Request;

class UserRequest extends ApiBaseRequest
{
    public function rules(Request $request){
        $route = $request->route()->getAction();
        $route['as'] = $route['as']??'';
        switch($route['as']){
            case "register":
                return [
                    'name' => 'required',
                    'password' => 'required|min:6|max:12',
                    'email'=>'required|email|unique:users,email'
                ];
                break;
                case "resetPassword":
                return [
                    'id'=>'required|integer'
                ];
                break;
            default:
                return [];
                break;
        }
    }

}
