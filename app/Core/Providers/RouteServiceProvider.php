<?php

namespace App\Core\Providers;

use Illuminate\Routing\RoutingServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $url = $this->app['url'];
        
        $url->forceRootUrl(config('app.url'));
    }
}
