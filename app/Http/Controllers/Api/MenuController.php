<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\MenuRequest;
use App\Imports\UsersImport;
use App\Logic\MenuLogic;
use App\Model\Popedom;
use Maatwebsite\Excel\Facades\Excel;

class MenuController extends ApiController
{
    public function __construct(MenuRequest $request)
    {
        parent::__construct($request);
    }

    //获取菜单列表接口
    public function getMenuList(){
        $userInfo = $this->userInfo;
        $userId   = $userInfo['id'];
        $data     = Popedom::getMenuList($userId);
        return  $this->ajaxReturn(E_SUCCESS,"",$data);
    }

    //demo
    public function demo(){
        Excel::import(new UsersImport,\request()->file("instructions"));
        return $this->ajaxReturn(E_SUCCESS,"读取成功");
    }



}
