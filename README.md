# Corals Payment Stripe

- Stripe has two environments Sandbox and Live, make sure to use sandbox for testing before going live

- Under Subscription -> Payment Settings you need to add your stripe account keys which can be grabbed from your stripe account :

<p><img src="https://www.laraship.com/wp-content/uploads/2017/12/stripe_settings.png" alt="" width="508" height="388"></p>
<p>&nbsp;</p>

- To enable Sandbox switch Sandbox mode to True.

- API Keys can be grabbed from https://dashboard.stripe.com/account/apikeys

<p><img src="https://www.laraship.com/wp-content/uploads/2017/12/stripe_api_keys.png"></p>
<p>&nbsp;</p>

- Webhooks Key can be grabbed from https://dashboard.stripe.com/account/webhooks

- Your Webhook URL should behttps://[you-domain.com]/webhooks/stripe

- <p><img src="https://www.laraship.com/wp-content/uploads/2017/12/strpe_webhooks.png"></p>
<p>&nbsp;</p>

- Webhooks Subscription Events:
```php
'invoice.created' => \Corals\Modules\Payment\Stripe\Job\HandleInvoiceCreated::class,
'invoice.payment_succeeded' => \Corals\Modules\Payment\Stripe\Job\HandleInvoicePaymentSucceeded::class,
'invoice.payment_failed' => \Corals\Modules\Payment\Stripe\Job\HandleInvoicePaymentFailed::class,
'customer.subscription.deleted' => \Corals\Modules\Payment\Stripe\Job\HandleCustomerSubscriptionDeleted::class,
'customer.subscription.trial_will_end' => \Corals\Modules\Payment\Stripe\Job\HandleCustomerTrialWillEnd::class,
```

### Enable Stripe Connect:
The stripe connect can be used to enable auto payout for vendors under Laraship Marketplace, this works by having vendors connecting their stripe to Laraship platform’s main Stripe account, and their payments will be transferred upon purchases, so no manual withdrawals needed. also once order cancelled the transfer will be reversed from the vendor account automatically.

<p>&nbsp;</p>

- To Enable Stripe Connect, go to Payments – Payment Settings – Stripe

- Activate Stripe Connect and insert Client ID as shown below

<p><img src="https://www.laraship.com/wp-content/uploads/2017/12/Laarvel-stripe-connect-1024x190.png"></p>
<p>&nbsp;</p>

The client ID can be obtained from https://dashboard.stripe.com/settings/applications

- Add Redirect URL to connect settings under Stripe, it should be {{doamin}}/stripe/authorize-connect

<p><img src="https://www.laraship.com/wp-content/uploads/2017/12/stripe-connect-key-redirect-1024x463.png"></p>
<p>&nbsp;</p>

- The vendor Should see a new tab under Store Settings, which will list the Stripe Connect link to connect to, click on “Connect with Stripe”, this will go through Stripe linking process

<p><img src="https://www.laraship.com/wp-content/uploads/2017/12/vendor-stripe-connect-settings-1024x391.png"></p>
<p>&nbsp;</p>


- once you complete the Stripe connect process you will be redirected to Laraship Platform and Stripe connect status will be turned to Connected

<p><img src="https://www.laraship.com/wp-content/uploads/2017/12/stripe-connect-redirect-1024x677.png"></p>
<p>&nbsp;</p>

<p><img src="https://www.laraship.com/wp-content/uploads/2017/12/vendor-stripe-connect-activated-1024x245.png"></p>
<p>&nbsp;</p>

- After that, Any order amount made for this vendor from orders will be transferred automatically to the Vendor stripe account after deducting the fees.

- <p><img src="https://www.laraship.com/wp-content/uploads/2017/12/vendor-payout.png"></p>
<p>&nbsp;</p>


## Installation

You can install the package via composer:

```bash
composer require corals/payment-stripe
```

## Testing

```bash
vendor/bin/phpunit vendor/corals/payment-stripe/tests 
```

## Hire Us
Looking for a professional team to build your success and start driving your business forward.
Laraship team ready to start with you [Hire Us](https://www.laraship.com/contact)
