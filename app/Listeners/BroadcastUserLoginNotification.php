<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

use App\Events\UserSessionChange;

class BroadcastUserLoginNotification
{
    public function __construct()
    {
        //
    }
    public function handle(Login $event): void
    {
        broadcast(new UserSessionChange("{$event->user->name} is online", "success"));
    }
}
