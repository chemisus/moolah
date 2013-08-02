<?php

namespace Moolah\AuthorizeNET;

use Moolah\PaymentTransaction;
use Moolah\TransactionAction;
use Moolah\TransactionActionState;
use Moolah\TransactionCommand;

class ChargePendingState extends StateTemplate implements TransactionActionState
{

    public function execute(
        TransactionCommand $transaction_command,
        PaymentTransaction $payment_transaction,
        TransactionAction $transaction_action
    ) {
        // get the api.
        $api = $this->makeAuthorizeNet();

        // request a new transaction.
        $response = $api->authorizeOnly(
            $transaction_action->getAmount(),
            $transaction_action->getCardNumber(),
            $transaction_action->getCardExpirationDate()
        );

        // set the transaction id.
        $payment_transaction->setTransactionID($response->transaction_id);

        // set the authorization code.
        $transaction_action->setAuthorizationCode($response->authorization_code);

        // move to a new state... i suggest anywhere but florida.
        $transaction_action->setTransactionState(3);

        // execute new states command. all hail the new boss.
        $transaction_command->execute();
    }
}