<?php

namespace PluckyPenguin\LaravelNordigen\Facades;

use Illuminate\Support\Facades\Facade;

class NordigenClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'nordigenclient';
    }
}
