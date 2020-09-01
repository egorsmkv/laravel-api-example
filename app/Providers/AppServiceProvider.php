<?php

namespace App\Providers;

use Appstract\Opcache\OpcacheServiceProvider;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider as TelescopeServiceProviderBase;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.env') === 'production') {
            $this->app->register(OpcacheServiceProvider::class);
        }

        if (config('app.env') === 'local') {
            $this->app->register(TelescopeServiceProviderBase::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
