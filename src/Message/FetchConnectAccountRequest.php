<?php

/**
 * Stripe Delete Customer Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Fetch Customer Request.
 *
 *
 * @link https://stripe.com/docs/api#retrieve_customer
 */
class FetchConnectAccountRequest extends AbstractRequest
{
    public function getAccountId()
    {
        return $this->getParameter('account_id');
    }

    public function setAccountId($value)
    {
        return $this->setParameter('account_id', $value);
    }

    public function getData()
    {
        $this->validate('account_id');
        return;
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/accounts/' . $this->getAccountId();
    }
}
