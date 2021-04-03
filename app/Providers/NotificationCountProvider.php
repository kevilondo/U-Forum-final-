<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\Controllers\NotifController;

class NotificationCountProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //display number of notification on navbar
        View::composer(['inc.navbar'], function($view){
            $notifications = new NotifController;
            $notifCount = $notifications->notifCount();
        
            return $view->with('notifCount', $notifCount);
        });
    }
}
