<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class EcoroWawiFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'ecoroWawi';
    }

}
