<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class ProxessWSFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'proxessWS';
    }

}
