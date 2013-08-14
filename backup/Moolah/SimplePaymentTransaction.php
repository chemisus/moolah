<?php

namespace Moolah;

class SimplePaymentTransaction implements PaymentTransaction
{
    private $transaction_id;

    public function __construct($transaction_id = null)
    {
        $this->transaction_id = $transaction_id;
    }

    public function getTransactionID()
    {
        return $this->transaction_id;
    }

    public function setTransactionID($value)
    {
        $this->transaction_id = $value;
    }
}