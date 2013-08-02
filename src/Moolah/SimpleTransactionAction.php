<?php

namespace Moolah;

abstract class SimpleTransactionAction implements TransactionAction
{

    private $transaction_type;

    private $response_code;

    public function __construct($transaction_type = null, $response_code = null)
    {
        $this->transaction_type = $transaction_type;
        $this->response_code    = $response_code;
    }

    public function isPending()
    {
        return $this->response_code === null;
    }

    public function getResponseCode()
    {
        return $this->response_code;
    }

    public function setResponseCode($value)
    {
        $this->response_code = $value;
    }
}