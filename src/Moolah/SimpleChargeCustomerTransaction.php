<?php

namespace Moolah;

class SimpleChargeCustomerTransaction extends SimpleTransactionAction implements ChargeCustomerTransactionAction
{

    private $amount;

    private $authorization_code;

    private $transaction_state;

    private $customer_profile_id;

    private $customer_payment_profile_id;

    private $customer_shipping_profile_id;

    public function __construct(
        $amount,
        $customer_profile_id,
        $customer_payment_profile_id,
        $customer_shipping_profile_id,
        $transaction_state = 1,
        $authorization_code = null,
        $transaction_status = null
    ) {
        parent::__construct($transaction_status);

        $this->amount                       = $amount;
        $this->customer_profile_id          = $customer_profile_id;
        $this->customer_payment_profile_id  = $customer_payment_profile_id;
        $this->customer_shipping_profile_id = $customer_shipping_profile_id;
        $this->authorization_code           = $authorization_code;
        $this->transaction_state            = $transaction_state;
    }

    /**
     * Gets the type of the transaction.
     *
     * @return mixed
     */
    public function getTransactionType()
    {
        return 'CHARGE';
    }

    /**
     * Gets the state of the transaction.
     *
     * @return integer
     */
    public function getTransactionState()
    {
        return $this->transaction_state;
    }

    /**
     * Sets the state of the transaction.
     *
     * @param integer $value
     *
     * @return integer
     */
    public function setTransactionState($value)
    {
        $this->transaction_state = $value;
    }

    /**
     * Get the amount the transaction is for.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get the authorization code needed to capture the payment.
     *
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorization_code;
    }

    /**
     * Set the authorization code returned by the server.
     *
     * @param string $value
     *
     * @return null
     */
    public function setAuthorizationCode($value)
    {
        $this->authorization_code = $value;
    }

    /**
     * Get the id of the customer profile to use.
     *
     * @return string
     */
    public function getCustomerProfileID()
    {
        return $this->customer_profile_id;
    }

    /**
     * Get the id of the payment profile to use.
     *
     * @return string
     */
    public function getCustomerPaymentProfileID()
    {
        return $this->customer_payment_profile_id;
    }

    /**
     * Get the id of the shipping profile to use.
     *
     * @return string
     */
    public function getCustomerShippingProfileID()
    {
        return $this->customer_shipping_profile_id;
    }
}