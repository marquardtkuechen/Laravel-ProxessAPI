<?php

namespace App\Providers;

use App\Services\MicrosoftGraphService;
use App\Services\EcoroWawiService;
use Illuminate\Support\ServiceProvider;

class EcoroWawiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ecoroWawi',function(){

            return new EcoroWawiService();

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
