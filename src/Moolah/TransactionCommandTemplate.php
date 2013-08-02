<?php

namespace Moolah;

class TransactionCommandTemplate implements TransactionCommand
{

    /**
     * @var TransactionActionState[]
     */
    private $transaction_states;

    /**
     * @var PaymentTransaction
     */
    private $payment_transaction;

    /**
     * @var ChargeCardTransactionAction
     */
    private $transaction_action;

    /**
     * @param PaymentTransaction       $payment_transaction
     * @param ChargeCardTransactionAction  $transaction_action
     * @param TransactionActionState[] $states
     */
    public function __construct(
        PaymentTransaction $payment_transaction,
        TransactionAction $transaction_action,
        $states
    ) {
        $this->payment_transaction = $payment_transaction;
        $this->transaction_action  = $transaction_action;
        $this->transaction_states  = $states;
    }

    public function execute()
    {
        $transaction_state = $this->transaction_action->getTransactionState();

        $state = $this->transaction_states[$transaction_state];

        $state->execute($this, $this->payment_transaction, $this->transaction_action);
    }
}