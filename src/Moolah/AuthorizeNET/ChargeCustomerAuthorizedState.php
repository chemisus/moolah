<?php

namespace Moolah\AuthorizeNET;

use Moolah\PaymentTransaction;
use Moolah\TransactionAction;
use Moolah\TransactionActionState;
use Moolah\TransactionCommand;

class ChargeCustomerAuthorizedState extends StateTemplate implements TransactionActionState
{

    public function execute(
        TransactionCommand $transaction_command,
        PaymentTransaction $payment_transaction,
        TransactionAction $transaction_action
    ) {
        // get the api.
        $api = $this->makeAuthorizeNetCIM();

//        // try to capture the payment.
        $transaction = new \AuthorizeNetTransaction();
        $transaction->approvalCode = $transaction_action->getAuthorizationCode();
        $transaction->amount = $transaction_action->getAmount();
        $transaction->customerProfileId = $transaction_action->getCustomerProfileID();
        $transaction->customerPaymentProfileId = $transaction_action->getCustomerPaymentProfileID();
        $transaction->customerShippingAddressId = $transaction_action->getCustomerShippingProfileID();
        $response = $api->createCustomerProfileTransaction("CaptureOnly", $transaction);

        var_dump($response);

        // set the transaction status.
        $transaction_action->setTransactionStatus($response->getTransactionResponse()->response_code);

        // move to a new state...
        $transaction_action->setTransactionState(2);

        // execute the new state command.
        $transaction_command->execute();
    }
}