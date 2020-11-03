<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RoleUserRequest extends ApiBaseRequest implements ApiRequest
{

    public function rules(Request $request)
    {
        $route = $request->route()->getAction();
        $route['as'] = $route['as']??'';
        switch($route['as']){
            case "bindRole":
                return [
                    'user_id'=>'required|integer',
                    'role_ids' => 'required|array',
                ];
                break;
            default:
                return [];
                break;
        }
    }
}
