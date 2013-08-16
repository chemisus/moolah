<?php

namespace Moolah;

class TestTransaction implements ChargeTransaction
{
    private $transaction_id;
    private $authorization_code;
    private $payment_profile;
    private $response_code;
    private $state;
    private $status;
    private $amount;

    public function __construct(
        PaymentProfile $payment_profile,
        $amount,
        $transaction_id = null,
        $authorization_code = null,
        $state = null,
        $status = null
    ) {
        $this->payment_profile = $payment_profile;
        $this->amount = $amount;
        $this->transaction_id = $transaction_id;
        $this->authorization_code = $authorization_code;
        $this->state = $state;
        $this->status = $status;
    }

    public function getAuthorizationCode()
    {
        return $this->authorization_code;
    }

    public function setAuthorizationCode($value)
    {
        $this->authorization_code = $value;
    }

    public function getCustomerProfileId()
    {
        return $this->payment_profile->getCustomerProfileId();
    }

    public function getPaymentProfileId()
    {
        return $this->payment_profile->getPaymentProfileId();
    }

    public function getTransactionAmount()
    {
        return $this->amount;
    }

    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    public function setTransactionId($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    public function getTransactionState()
    {
        return $this->state;
    }

    public function setTransactionState($value)
    {
        $this->state = $value;
    }

    public function getTransactionStatus()
    {
        return $this->status;
    }

    public function setTransactionStatus($value)
    {
        $this->status = $value;
    }

    public function setTransactionResponseCode($value)
    {
        $this->response_code = $value;
    }
}