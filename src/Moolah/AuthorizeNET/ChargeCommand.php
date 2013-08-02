<?php

namespace Moolah\AuthorizeNET;

use Moolah\ChargeTransactionAction;
use Moolah\PaymentTransaction;
use Moolah\TransactionCommandTemplate;

class ChargeCommand extends TransactionCommandTemplate
{
    public function __construct(
        $login_key,
        $transaction_key,
        PaymentTransaction $payment_transaction,
        ChargeTransactionAction $transaction_action
    ) {
        parent::__construct(
            $payment_transaction,
            $transaction_action,
            [
                1 => new ChargePendingState($login_key, $transaction_key),
                2 => new ChargeFinalizedState($login_key, $transaction_key),
                3 => new ChargeAuthorizedState($login_key, $transaction_key),
            ]
        );
    }
}