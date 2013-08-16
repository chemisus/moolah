<?php

namespace Moolah;

class TestTransaction implements AuthorizeTransaction, CaptureTransaction, VoidTransaction, RefundTransaction
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

}