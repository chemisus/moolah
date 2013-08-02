<?php

namespace Moolah\AuthorizeNET;

use Moolah\ChargeCardTransactionAction;
use Moolah\PaymentTransaction;
use Moolah\TransactionCommandTemplate;

class ChargeCardCommand extends TransactionCommandTemplate
{

    public function __construct(
        $login_key,
        $transaction_key,
        PaymentTransaction $payment_transaction,
        ChargeCardTransactionAction $transaction_action
    ) {
        parent::__construct(
            $payment_transaction,
            $transaction_action,
            [
                1 => new ChargeCardPendingState($login_key, $transaction_key),
                2 => new ChargeCardFinalizedState($login_key, $transaction_key),
                3 => new ChargeCardAuthorizedState($login_key, $transaction_key),
            ]
        );
    }
}