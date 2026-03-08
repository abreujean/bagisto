<?php

namespace Webkul\Asaas\Providers;

use Illuminate\Support\ServiceProvider;

class AsaasServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerConfig();
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'asaas');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'asaas');
        $this->app->register(EventServiceProvider::class);
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/paymentmethods.php',
            'payment_methods'
        );
    }
}
