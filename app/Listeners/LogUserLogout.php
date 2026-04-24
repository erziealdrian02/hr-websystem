<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Logout;

class LogUserLogout
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        /** @var \App\Models\User|null $user */
        $user = $event->user;

        if ($user) {
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'Logout',
                'model_type' => 'User',
                'log' => [
                    'message' => 'User logged out',
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'logout_at' => now()->toDateTimeString(),
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }
}
