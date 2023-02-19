<?php

/**
 * Stripe Create Plan Request.
 */

namespace Corals\Modules\Payment\Stripe\Message;

/**
 * Stripe Create Plan Request
 *
 * @see Corals\Modules\Payment\Stripe\Gateway
 * @link https://stripe.com/docs/api#create_plan
 */
class CreatePlanRequest extends AbstractRequest
{
    /**
     * Set the plan ID
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setId($planId)
    {
        return $this->setParameter('id', $planId);
    }

    /**
     * Get the plan ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set the plan amount
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setAmount($planAmount)
    {
        return $this->setParameter('amount', $planAmount);
    }

    /**
     * Get the plan amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    /**
     * Set the plan currency
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setCurrency($planCurrency)
    {
        return $this->setParameter('currency', $planCurrency);
    }

    /**
     * Get the plan currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    /**
     * Set the plan interval
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setInterval($planInterval)
    {
        return $this->setParameter('interval', $planInterval);
    }

    /**
     * Get the plan interval
     *
     * @return int
     */
    public function getInterval()
    {
        return $this->getParameter('interval');
    }

    /**
     * Set the plan interval count
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setIntervalCount($planIntervalCount)
    {
        return $this->setParameter('interval_count', $planIntervalCount);
    }

    /**
     * Get the plan interval count
     *
     * @return int
     */
    public function getIntervalCount()
    {
        return $this->getParameter('interval_count');
    }

    /**
     * Set the plan name
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setName($planName)
    {
        return $this->setParameter('name', $planName);
    }

    /**
     * Get the product name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->getParameter('product_name');
    }


    /**
     * Set the product name
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setProductName($productName)
    {
        return $this->setParameter('product_name', $productName);
    }

    /**
     * Get the plan name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getParameter('name');
    }


    /**
     * Set the plan statement descriptor
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setStatementDescriptor($planStatementDescriptor)
    {
        return $this->setParameter('statement_descriptor', $planStatementDescriptor);
    }

    /**
     * Get the plan statement descriptor
     *
     * @return string
     */
    public function getStatementDescriptor()
    {
        return $this->getParameter('statement_descriptor');
    }

    /**
     * Set the plan trial period days
     *
     * @return CreatePlanRequest provides a fluent interface.
     */
    public function setTrialPeriodDays($planTrialPeriodDays)
    {
        return $this->setParameter('trial_period_days', $planTrialPeriodDays);
    }

    /**
     * Get the plan trial period days
     *
     * @return int
     */
    public function getTrialPeriodDays()
    {
        return $this->getParameter('trial_period_days');
    }

    /**
     * @return array|mixed
     * @throws \Corals\Modules\Payment\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('id', 'amount', 'currency', 'interval', 'product_name', 'name');

        $data = array(
            'id' => $this->getId(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'interval' => $this->getInterval(),
            'nickname' => $this->getName()
        );

        $intervalCount = $this->getIntervalCount();
        if ($intervalCount != null) {
            $data['interval_count'] = $intervalCount;
        }

        $product = ['name' => $this->getProductName(), 'type' => 'service'];

        $statementDescriptor = $this->getStatementDescriptor();
        if ($statementDescriptor != null) {
            $product['statement_descriptor'] = $statementDescriptor;
        }

        $data['product'] = $product;


        $trialPeriodDays = $this->getTrialPeriodDays();
        if ($trialPeriodDays != null) {
            $data['trial_period_days'] = $trialPeriodDays;
        }

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint . '/plans';
    }
}
