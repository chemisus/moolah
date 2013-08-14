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
        $t                            = new \AuthorizeNetTransaction();
        $t->approvalCode              = $transaction_action->getAuthorizationCode();
        $t->amount                    = $transaction_action->getAmount();
        $t->customerProfileId         = $transaction_action->getCustomerProfileID();
        $t->customerPaymentProfileId  = $transaction_action->getCustomerPaymentProfileID();
        $t->customerShippingAddressId = $transaction_action->getCustomerShippingProfileID();
        $response                               = $api->createCustomerProfileTransaction("CaptureOnly", $t);

        // set the transaction status.
        $transaction_action->setTransactionStatus($response->getTransactionResponse()->response_code);

        // move to a new state...
        $transaction_action->setTransactionState(2);

        // execute the new state command.
        $transaction_command->execute();
    }
}