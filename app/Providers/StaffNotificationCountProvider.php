<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\Controllers\NotifController;

use Illuminate\Support\Facades\View;

class StaffNotificationCountProvider extends ServiceProvider
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
        //Display number of notification for staff on navbar
        View::composer(['inc.staffnavbar'], function($view){
            $notifications = new NotifController;
            $notifCount = $notifications->notifCount();
        
            $view->with('notifCount', $notifCount);
        });
    }
}
