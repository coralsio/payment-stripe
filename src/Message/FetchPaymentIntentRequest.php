<?php

/**
 * Stripe Payment Intent Fetch Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;


/**
 * Stripe Fetch Payment Intent Request.
 *
 *  // Check if we're good!
 *  $paymentIntent = $gateway->fetchPaymentIntent(array(
 *      'paymentIntentReference' => $paymentIntentReference,
 *  ));
 *
 *  $response = $paymentIntent->send();
 *
 *  if ($response->isSuccessful()) {
 *    // All done. Rejoice.
 *  }
 *
 * @link https://stripe.com/docs/api/payment_intents/retrieve
 */
class FetchPaymentIntentRequest extends AbstractRequest
{
    /**
     * @inheritdoc
     */
    public function getData()
    {
        $this->validate('paymentIntentReference');
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
    public function getHttpMethod()
    {
        return 'GET';
    }

    /**
     * @inheritdoc
     */
    public function getEndpoint()
    {
        return $this->endpoint . '/payment_intents/' . $this->getPaymentIntentReference();
    }

    /**
     * @inheritdoc
     */
    protected function createResponse($data, $headers = [])
    {
        return $this->response = new Response($this, $data, $headers);
    }
}
