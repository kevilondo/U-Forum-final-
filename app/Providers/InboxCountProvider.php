<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\Controllers\InboxController;

use Illuminate\Support\Facades\View;

class InboxCountProvider extends ServiceProvider
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
        //display number of messages on navbar

        View::composer(['inc.navbar'], function($view){
            $messages = new InboxController;
            $messagesCount = $messages->messagesCount();
        
            return $view->with('messagesCount', $messagesCount);
        });
    }
}
