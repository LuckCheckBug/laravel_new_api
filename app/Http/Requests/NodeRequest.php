<?php


namespace App\Http\Requests;


use Illuminate\Http\Request;

class NodeRequest extends ApiBaseRequest implements ApiRequest
{

    public function rules(Request $request)
    {
        $route = $request->route()->getAction();
        $route['as'] = $route['as']??'';
        switch($route['as']){
            case "addNode":
                return [
                    'version_id' => 'required|integer',
                    'node_name' => 'required',
                    'check_date' => 'required|date',
                ];
                break;
            case "getNodeList":
                return [
                    'version_id' => 'required|integer',
                ];
                break;
            case "updateNode":
                return [
                    'node_id'=>'required|integer',
                    'version_id' => 'required|integer',
                    'node_name' => 'required',
                    'check_date' => 'required|date',
                ];
                break;
            case "delNode":
                return [
                    'node_id'=>'required|integer',
                ];
                break;
            default:
                return [];
                break;
        }
    }
    //字段翻译
    public function attributes()
    {
        return [
            'version_id'=>"版本ID",
            'node_name'=>"节点名称",
            'check_date'=>"验证时间",
            'node_id'=>"节点ID",
        ];
    }
}
