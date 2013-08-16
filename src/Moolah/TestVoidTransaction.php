<?php

namespace Moolah;

class TestVoidTransaction implements VoidTransaction
{
    private $transaction_id;
    private $reference_id;
    private $authorization_code;
    private $payment_profile;
    private $response_code;
    private $state;
    private $status;
    private $amount;
    private $response_reason_code;

    public function __construct(
        PaymentProfile $payment_profile,
        $amount,
        $reference_id = null,
        $authorization_code = null,
        $state = null,
        $status = null
    ) {
        $this->payment_profile = $payment_profile;
        $this->amount = $amount;
        $this->reference_id = $reference_id;
        $this->authorization_code = $authorization_code;
        $this->state = $state;
        $this->status = $status;
    }

    public function startingVoid()
    {
    }

    public function finishedVoid($response_code, $response_reason_code)
    {
        $this->response_code = $response_code;
        $this->response_reason_code = $response_reason_code;
    }

    public function getReferenceId()
    {
        return $this->reference_id;
    }

    public function getTransactionState()
    {
        // TODO: Implement getTransactionState() method.
    }

    public function getTransactionStatus()
    {
        // TODO: Implement getTransactionStatus() method.
    }
}