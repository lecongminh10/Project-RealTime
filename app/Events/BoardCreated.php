<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Board;
class BoardCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userid;

    public $member;

    public $board;


    public function __construct($userid , $member ,$board)
    {

        $this ->userid = $userid;
        $this ->member = $member;
        $this ->board = $board;

    }

    public function broadcastOn()
    {
        return  new Channel('board');
    }
}
