<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskDelete implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $task;
    public $create_by;


    public function __construct(Task $task, $create_by)
    {
        $this->task = $task;
        $this->create_by = $create_by;
    }
 
    public function broadcastOn()
    {
        return new Channel('task');
    }
}
