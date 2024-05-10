<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserOnline implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $create_by;

    public $user;
    public $message;
    public function __construct($user , $message )
    {
            $this ->user = $user;
            $this ->message = $message;
            // $this ->create_by= $create_by;
    }

    public function broadcastOn()
    {
        return [
            new PresenceChannel('usersonline'),
        ];
    }
}
