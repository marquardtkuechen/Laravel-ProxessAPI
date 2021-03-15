<?php

namespace App\Providers;

use App\Services\MicrosoftGraphService;
use App\Services\ProxessWSService;
use Illuminate\Support\ServiceProvider;

class ProxessWSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('proxessWS',function(){

            return new ProxessWSService();

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
