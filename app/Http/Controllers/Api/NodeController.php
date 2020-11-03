<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiController;
use App\Http\Requests\NodeRequest;
use App\Model\Node;

class NodeController extends ApiController
{
    public function __construct(NodeRequest $request)
    {
        parent::__construct($request);
    }

    //添加节点
    public function addNode(){
        $param   = request(['version_id','node_name','check_date']);
        $bool    = Node::addNode($param);
        return $this->boolReturn($bool);
    }

    //删除节点
    public function delNode(){
        $param   = request(['node_id']);
        $bool    = Node::delNode($param['node_id']);
        return $this->boolReturn($bool,'delete');
    }

    //修改节点
    public function updateNode(){
        $param = $this->param;
        $updateData = [
            'check_date'=>$param['check_date'],
            'version_id'=>$param['version_id'],
            'node_name' =>$param['node_name']
        ];
        $bool = Node::updateNode($param['node_id'],$updateData);
        return $this->boolReturn($bool,'update');
    }

    //获取版本的节点列表
    public function getNodeList(){
        $where = request(['version_id']);
        $data  = Node::getNodeList($where);
        //$data  = Node::test();
        return $this->ajaxReturn(E_SUCCESS,'',$data);
    }


}
