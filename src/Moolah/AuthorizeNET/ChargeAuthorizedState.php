<?php

namespace Moolah\AuthorizeNET;

use Moolah\PaymentTransaction;
use Moolah\TransactionAction;
use Moolah\TransactionActionState;
use Moolah\TransactionCommand;

class ChargeAuthorizedState extends StateTemplate implements TransactionActionState
{

    public function execute(
        TransactionCommand $transaction_command,
        PaymentTransaction $payment_transaction,
        TransactionAction $transaction_action
    ) {
        // get the api.
        $api = $this->makeAuthorizeNet();

        // try to capture the payment.
        $response = $api->captureOnly(
            $transaction_action->getAuthorizationCode(),
            $transaction_action->getAmount(),
            $transaction_action->getCardNumber(),
            $transaction_action->getCardExpirationDate()
        );

        // set the transaction status.
        $transaction_action->setTransactionStatus($response->response_code);

        // move to a new state...
        $transaction_action->setTransactionState(2);

        // execute the new state command.
        $transaction_command->execute();
    }
}