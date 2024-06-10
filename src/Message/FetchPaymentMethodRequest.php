<?php

/**
 * Stripe Payment Method Fetch Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;


/**
 * Class FetchPaymentIntentRequest
 * @package Corals\Modules\Payment\Stripe\Message
 */
class FetchPaymentMethodRequest extends AbstractRequest
{
    /**
     * @inheritdoc
     */
    public function getData()
    {
        $this->validate('paymentMethodId');
    }

    public function setPaymentMethodId($value)
    {
        return $this->setParameter('paymentMethodId', $value);
    }

    /**
     * @return mixed
     */
    public function getPaymentMethodId()
    {
        return $this->getParameter('paymentMethodId');
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
        return $this->endpoint . '/payment_methods/' . $this->getPaymentMethodId();
    }

    /**
     * @inheritdoc
     */
    protected function createResponse($data, $headers = [])
    {
        return $this->response = new Response($this, $data, $headers);
    }
}
