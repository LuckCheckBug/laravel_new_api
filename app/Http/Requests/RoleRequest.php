<?php


namespace App\Http\Requests;


use Illuminate\Http\Request;

class RoleRequest extends ApiBaseRequest implements ApiRequest
{
    public function rules(Request $request){
        $route = $request->route()->getAction();
        $route['as'] = $route['as']??'';
        switch($route['as']){
            case "addRole":
                return [
                    'name' => 'required|unique:role,name',
                ];
                break;
            default:
                return [];
                break;
        }
    }

}
