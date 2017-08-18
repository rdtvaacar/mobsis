<?php

namespace Acr\Mobsis\Facades;

use Illuminate\Support\Facades\Facade;

class AcrMobsis extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AcrMobsis';
    }

}