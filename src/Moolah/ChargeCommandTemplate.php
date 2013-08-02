<?php

namespace Moolah;

abstract class ChargeCommandTemplate
{

    private $payment_transaction;

    private $transaction_action;

    public function __construct(PaymentTransaction $payment_transaction, TransactionAction $transaction_action)
    {
        $this->payment_transaction = $payment_transaction;

        $this->transaction_action = $transaction_action;
    }

    public function execute()
    {
        $this->payment_transaction->setTransactionID(null);

        $transaction_id = $this->authorize();

        $this->payment_transaction->setTransactionID($transaction_id);

        $response_code = $this->capture();

        $this->transaction_action->setTransactionActionStatus($response_code);
    }

    abstract public function authorize();

    abstract function capture();
}
