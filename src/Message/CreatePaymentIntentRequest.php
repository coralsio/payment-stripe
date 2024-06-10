<?php

/**
 * Stripe Payment Intent Create Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;


/**
 * Class CreatePaymentIntentRequest
 * @package Corals\Modules\Payment\Stripe\Message
 */
class CreatePaymentIntentRequest extends AbstractRequest
{
    /**
     * @param $value
     * @return CreatePaymentIntentRequest
     */
    public function getIntentRequestData()
    {
        return $this->getParameter('intentRequestData');
    }

    /**
     * @param $value
     * @return CreatePaymentIntentRequest
     */
    public function setIntentRequestData($value)
    {
        return $this->setParameter('intentRequestData', $value);
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $this->validate('amount');
        
        $data = $this->getIntentRequestData();

        $data['amount'] = $this->getAmountInteger();

        return $data;
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
        return $this->endpoint . '/payment_intents';
    }

    /**
     * @inheritdoc
     */
    protected function createResponse($data, $headers = [])
    {
        return $this->response = new Response($this, $data, $headers);
    }
}
