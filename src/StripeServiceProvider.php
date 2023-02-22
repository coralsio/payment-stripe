<?php

namespace Corals\Modules\Payment\Stripe;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Modules\Payment\Stripe\Providers\StripeRouteServiceProvider;
use Corals\Settings\Facades\Modules;

class StripeServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $defer = false;
    /**
     * @var
     */
    protected $packageCode = 'corals-payment-stripe';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function bootPackage()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerPackage()
    {
        $this->app->register(StripeRouteServiceProvider::class);
    }

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/payment-stripe');
    }
}
