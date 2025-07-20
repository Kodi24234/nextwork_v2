<?php
namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use a view composer to share notification data with the header partial
        View::composer('layouts.partials.header', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                // Get the 5 most recent unread notifications
                $notifications = $user->unreadNotifications()->limit(5)->get();
                $unreadCount   = $user->unreadNotifications()->count();
            } else {
                $notifications = collect(); // Return an empty collection if no user
                $unreadCount   = 0;
            }

            $view->with([
                'notifications' => $notifications,
                'unreadCount'   => $unreadCount,
            ]);
        });

    }
}
