<?php

namespace Moolah;

class TestTransaction implements AuthorizeTransaction, CaptureTransaction, RefundTransaction
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

    public function startingAuthorize()
    {
    }

    public function startingCapture()
    {
    }

    public function startingRefund()
    {
    }

    public function finishedAuthorize($transaction_id, $authorization_code, $response_code, $response_reason_code)
    {
        $this->transaction_id = $transaction_id;
        $this->authorization_code = $authorization_code;
        $this->response_code = $response_code;
        $this->response_reason_code = $response_reason_code;
    }

    public function finishedCapture($transaction_id, $response_code, $response_reason_code)
    {
        $this->transaction_id = $transaction_id;
        $this->response_code = $response_code;
        $this->response_reason_code = $response_reason_code;
    }

    public function finishedRefund($transaction_id, $response_code, $response_reason_code)
    {
        $this->transaction_id = $transaction_id;
        $this->response_code = $response_code;
        $this->response_reason_code = $response_reason_code;
    }

    public function getAuthorizationCode()
    {
        return $this->authorization_code;
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

    public function getReferenceId()
    {
        return $this->reference_id;
    }

    public function getTransactionState()
    {
    }

    public function getTransactionStatus()
    {
    }

}