<?php

namespace App\Units\Api\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function register()
    {
        $this->mapApiRoutes();
    }

    public function mapApiRoutes()
    {
        $this->app->router->group([
            'prefix' => 'api',
            'namespace' => 'App\Units\Api\Http\Controllers',
        ], function ($router) {
            require __DIR__.'/../routes.php';
        });
    }
}
