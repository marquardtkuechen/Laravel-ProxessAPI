<?php

namespace App\Providers;

use App\Services\MicrosoftGraphService;
use Illuminate\Support\ServiceProvider;

class MicrosoftGraphServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('microsoftGraph',function(){

            return new MicrosoftGraphService();

        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
