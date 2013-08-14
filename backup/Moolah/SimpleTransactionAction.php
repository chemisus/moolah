<?php

namespace Moolah;

abstract class SimpleTransactionAction implements TransactionAction
{

    private $transaction_status;

    public function __construct($transaction_status = null)
    {
        $this->transaction_status = $transaction_status;
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