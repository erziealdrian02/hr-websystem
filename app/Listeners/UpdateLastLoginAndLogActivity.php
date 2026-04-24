<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;

class UpdateLastLoginAndLogActivity
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
    public function handle(Login $event): void
    {
        /** @var \App\Models\User $user */
        $user = $event->user;

        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
            'last_login_user_agent' => request()->userAgent(),
        ]);

        // Create Activity Log
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Login',
            'model_type' => 'User',
            'log' => [
                'message' => 'User logged in',
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'login_at' => now()->toDateTimeString(),
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
