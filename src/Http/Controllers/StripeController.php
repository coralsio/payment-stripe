<?php

namespace Corals\Modules\Payment\Stripe\Http\Controllers;

use Corals\Foundation\Http\Controllers\PublicBaseController;
use Corals\Modules\Payment\Classes\Payments;
use Illuminate\Http\Request;

class StripeController extends PublicBaseController
{
    protected $gateway;
    /**
     * @var Payments
     */
    protected Payments $payments;

    protected function initGateway()
    {
        $payments = new Payments('Stripe');

        $this->payments = $payments;
        $this->gateway = $payments->gateway;
    }

    public function authorizeConnect(Request $request)
    {
        try {
            $this->initGateway();

            \Stripe\Stripe::setApiKey($this->gateway->getApiKey());

            $response = \Stripe\OAuth::token([
                'grant_type' => 'authorization_code',
                'code' => $request->get('code'),
            ]);

            $account_id = $response->stripe_user_id;

            $this->payments->fetchConnectAccount($account_id);
        } catch (\Exception $exception) {
            log_exception($exception);
        }

        return redirect('marketplace/store/settings#connect-accounts');
    }
}
