<?php

namespace Moolah;

class TestTransaction implements ChargeTransaction
{

    private $authorization_code;
    private $transaction_amount;
    private $transaction_id;
    private $transaction_state;
    private $transaction_status;

    public function __construct(
        $transaction_amount,
        $transaction_id = null,
        $transaction_state = null,
        $transaction_status = null,
        $authorization_code = null
    ) {
        $this->transaction_id     = $transaction_id;
        $this->authorization_code = $authorization_code;
        $this->transaction_status = $transaction_status;
        $this->transaction_state  = $transaction_state;
        $this->transaction_amount = $transaction_amount;
    }

    public function getAuthorizationCode()
    {
        return $this->authorization_code;
    }

    public function setAuthorizationCode($value)
    {
        $this->authorization_code = $value;
    }

    public function getTransactionAmount()
    {
        return $this->transaction_amount;
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
        return $this->transaction_state;
    }

    public function setTransactionState($value)
    {
        $this->transaction_state = $value;
    }

    public function getTransactionStatus()
    {
        return $this->transaction_status;
    }

    public function setTransactionStatus($value)
    {
        $this->transaction_status = $value;
    }
}