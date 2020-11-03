<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;


class UpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $objModel;

    public $action = "update";
    /**
     * CreateEvent constructor.
     * @param $objModel
     */
    public function __construct($objModel)
    {
        $this->objModel = $objModel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
