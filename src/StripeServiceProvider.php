<?php

namespace Corals\Modules\Payment\Stripe;

use Corals\Modules\Payment\Stripe\Providers\StripeRouteServiceProvider;
use Illuminate\Support\ServiceProvider;
use Corals\Settings\Facades\Modules;

class StripeServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
//        $this->registerModulesPackages();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(StripeRouteServiceProvider::class);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/payment-stripe');
    }
}
