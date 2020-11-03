<?php


namespace App\Http\Requests;


use Illuminate\Http\Request;

class VersionRequest extends ApiBaseRequest implements ApiRequest
{

    public function rules(Request $request)
    {
        $route = $request->route()->getAction();
        $route['as'] = $route['as']??'';
        switch($route['as']){
            case "addVersion":
                return [
                    'project_id' => 'required|integer',
                    'version_name' => 'required',
                ];
                break;
            case "getVersionList":
                return [
                    'project_id' => 'required|integer',
                ];
                break;
            default:
                return [];
                break;
        }

        // TODO: Implement rules() method.
    }
    //字段翻译
    public function attributes()
    {
        return [
            'project_id'=>"项目ID",
            'version_name'=>"版本名称",
            'version_id'=>"版本ID",
        ];
    }
}
