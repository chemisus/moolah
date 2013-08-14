<?php

namespace Moolah\AuthorizeNET;

use Moolah\PaymentTransaction;
use Moolah\TransactionAction;
use Moolah\TransactionActionState;
use Moolah\TransactionCommand;

class ChargeCustomerPendingState extends StateTemplate implements TransactionActionState
{

    public function execute(
        TransactionCommand $transaction_command,
        PaymentTransaction $payment_transaction,
        TransactionAction $transaction_action
    ) {
        // get the api.
        $api = $this->makeAuthorizeNetCIM();

        // request a new transaction.
        $transaction = new \AuthorizeNetTransaction();

        $transaction->amount = $transaction_action->getAmount();
        $transaction->customerProfileId = $transaction_action->getCustomerProfileID();
        $transaction->customerPaymentProfileId = $transaction_action->getCustomerPaymentProfileID();
        $transaction->customerShippingAddressId = $transaction_action->getCustomerShippingProfileID();

        $response = $api->createCustomerProfileTransaction("AuthOnly", $transaction);

        // set the transaction id.
        $payment_transaction->setTransactionID($response->getTransactionResponse()->transaction_id);

        // set the authorization code.
        $transaction_action->setAuthorizationCode($response->getTransactionResponse()->authorization_code);

        // move to a new state... i suggest anywhere but florida.
        $transaction_action->setTransactionState(3);

        // execute new states command. all hail the new boss.
        $transaction_command->execute();
    }
}