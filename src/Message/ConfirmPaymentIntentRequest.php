<?php

/**
 * Stripe Payment Intent Confirm Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Confirm Payment Intent Request.
 *
 * This request is sent behind the scenes whenever an authorize or purchase request
 * is performed by the Payment Intents gateway. The previous authorize or purchase request
 * "primes" the purchase or authorization and this request confirms it.
 *
 * The response to this request indicates whether the payment requires 3DS authentication,
 * in which case it will be a redirect response.
 *
 * For examples, refer to related purchase and authorization classes.
 *
 * @link https://stripe.com/docs/api/payment_intents/confirm
 */
class ConfirmPaymentIntentRequest extends AbstractRequest
{
    /**
     * @inheritdoc
     */
    public function getData()
    {
        $this->validate('paymentIntentReference');
        $data = array();
        if ($this->getReturnUrl()) {
            $data['return_url'] = $this->getReturnUrl();
        }
        return $data;
    }

    public function setPaymentIntentReference($value)
    {
        return $this->setParameter('paymentIntentReference', $value);
    }

    /**
     * @return mixed
     */
    public function getPaymentIntentReference()
    {
        return $this->getParameter('paymentIntentReference');
    }

    /**
     * @inheritdoc
     */
    public function getEndpoint()
    {
        return $this->endpoint . '/payment_intents/' . $this->getPaymentIntentReference() . '/confirm';
    }

    /**
     * @inheritdoc
     */
    protected function createResponse($data, $headers = [])
    {
        return $this->response = new Response($this, $data, $headers);
    }
}
