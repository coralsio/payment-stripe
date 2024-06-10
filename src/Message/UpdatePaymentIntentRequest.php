<?php

/**
 * Stripe Payment Intent Fetch Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;


/**
 * Class CreatePaymentIntentRequest
 * @package Corals\Modules\Payment\Stripe\Message
 */
class UpdatePaymentIntentRequest extends AbstractRequest
{

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $this->validate('amount');

        return [
            'amount' => $this->getAmountInteger(),
        ];
    }

    public function setPaymentIntentId($value)
    {
        return $this->setParameter('paymentIntentId', $value);
    }

    /**
     * @return mixed
     */
    public function getPaymentIntentId()
    {
        return $this->getParameter('paymentIntentId');
    }



    /**
     * @inheritdoc
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @inheritdoc
     */
    public function getEndpoint()
    {
        return $this->endpoint . '/payment_intents/' . $this->getPaymentIntentId();
    }

    /**
     * @inheritdoc
     */
    protected function createResponse($data, $headers = [])
    {
        return $this->response = new Response($this, $data, $headers);
    }
}
