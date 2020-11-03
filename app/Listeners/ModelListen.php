<?php

namespace App\Listeners;

use App\Logic\WriteLogLogic;
use App\Model\SysLog;
use Illuminate\Http\Request;

class ModelListen
{
    private $userInfo;

    public function __construct(){
        $this->userInfo = auth('api')->user();
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $data['value_id'] = $event->objModel->id;
        $data['user_id']  = $this->userInfo->id;
        $data['param']    = json_encode($event->objModel);
        $data['original'] = json_encode($event->objModel->getOriginal());
        $data['action']   = $event->action;
        $data['table'] = $event->objModel->getTable();
        $data['created_at'] = date("Y-m-d H:i:s");
        SysLog::create($data);
    }
}
