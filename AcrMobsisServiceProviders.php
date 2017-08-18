<?php

namespace Acr\Mobsis;

use Acr\Mobsis\Controllers\AcrMobsisController;
use Illuminate\Support\ServiceProvider;

class AcrMobsisServiceProviders extends ServiceProvider
{
    public function boot()
    {
        include(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/Views', 'acr_mobsis');
    }

    public function register()
    {
        $this->app->bind('AcrMobsis', function () {
            return new AcrMobsisController();
        });
    }
}