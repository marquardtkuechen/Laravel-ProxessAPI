<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class MicrosoftGraphFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'microsoftGraph';
    }

}
