<?php

namespace Moolah\AuthorizeNET;

use Moolah\ChargeCustomerTransactionAction;
use Moolah\PaymentTransaction;
use Moolah\TransactionCommandTemplate;

class ChargeCustomerCommand extends TransactionCommandTemplate
{

    public function __construct(
        $login_key,
        $transaction_key,
        PaymentTransaction $payment_transaction,
        ChargeCustomerTransactionAction $transaction_action
    ) {
        parent::__construct(
            $payment_transaction,
            $transaction_action,
            [
                1 => new ChargeCustomerPendingState($login_key, $transaction_key),
                2 => new ChargeCustomerFinalizedState($login_key, $transaction_key),
                3 => new ChargeCustomerAuthorizedState($login_key, $transaction_key),
            ]
        );
    }
}
