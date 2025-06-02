<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\ProductActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register any bindings or services
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Listen for login events
        Event::listen(Login::class, function ($event) {
            $this->logActivity('login', $event->user->id);
        });

        // Listen for logout events
        Event::listen(Logout::class, function ($event) {
            $this->logActivity('logout', $event->user->id);
        });
    }

    /**
     * Log an activity
     */
    protected function logActivity(string $activity, $userId = null, $productId = null): void
    {
        ProductActivityLog::create([
            'user_id'    => $userId,
            'product_id' => $productId,
            'activity'   => $activity,
            'ip'         => Request::ip(),
            'user_agent' => Request::userAgent(),
            'created_at' => now(),
        ]);
    }
}
