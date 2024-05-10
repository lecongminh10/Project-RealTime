<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use App\Events\UserSessionChange;
class BroadcastUserLogoutNotification
{
    public function __construct()
    {
        //
    }
    public function handle(Logout $event): void
    {
        broadcast(new UserSessionChange("{$event->user->name} is offline", "danger"));
    }
}
