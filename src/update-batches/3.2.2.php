<?php

use Corals\Settings\Models\Module;

$stripeModule = Module::query()->where('code', 'corals-payment-stripe')
    ->first();

$stripeModule->update([
    'provider' => \Corals\Modules\Payment\Stripe\StripeServiceProvider::class,
]);
