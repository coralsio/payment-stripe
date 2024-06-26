<?php

namespace Corals\Modules\Payment\Stripe\Providers;

use Corals\Foundation\Models\GatewayStatus;
use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Settings\Models\Setting;
use Corals\User\Models\User;
use Illuminate\Support\Facades\Schema;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected function providerBooted()
    {

        $supported_gateways = \Settings::get('supported_payment_gateway', []);

        if (is_array($supported_gateways)) {
            unset($supported_gateways['Stripe']);
        }

        \Settings::set('supported_payment_gateway', json_encode($supported_gateways));

        Setting::where('code', 'like', 'payment_stripe%')->delete();

        if (Schema::hasColumn('users', 'gateway')) {
            User::where('gateway', 'Stripe')->update(['gateway' => NULL]);
        }

        GatewayStatus::where('gateway', 'Stripe')->delete();
    }
}
