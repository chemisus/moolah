<?php

namespace Moolah;

interface TransactionActionState
{

    public function execute(
        TransactionCommand $transaction_command,
        PaymentTransaction $payment_transaction,
        TransactionAction $transaction_action
    );
}