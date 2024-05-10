<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

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