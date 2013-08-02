<?php

namespace Moolah\AuthorizeNET;

use Moolah\PaymentTransaction;
use Moolah\TransactionAction;
use Moolah\TransactionActionState;
use Moolah\TransactionCommand;

class ChargeCardFinalizedState implements TransactionActionState
{

    public function execute(
        TransactionCommand $transaction_command,
        PaymentTransaction $payment_transaction,
        TransactionAction $transaction_action
    ) {
    }
}