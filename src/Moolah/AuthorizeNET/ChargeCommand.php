<?php

namespace Moolah\AuthorizeNET;

use AuthorizeNetAIM;
use Moolah\ChargeCommandTemplate;
use Moolah\ChargeTransactionAction;
use Moolah\PaymentTransaction;

class ChargeCommand extends ChargeCommandTemplate
{

    private $login_key;

    private $transaction_key;

    private $transaction_action;

    public function __construct(
        PaymentTransaction $payment_transaction,
        ChargeTransactionAction $transaction_action,
        $login_key,
        $transaction_key
    ) {
        parent::__construct($payment_transaction, $transaction_action);

        $this->transaction_action = $transaction_action;
        $this->login_key          = $login_key;
        $this->transaction_key    = $transaction_key;
    }

    public function authorize()
    {
        $api = $this->makeAuthorizeNet();

        $response = $api->authorizeOnly(
            $this->transaction_action->getAmount(),
            $this->transaction_action->getCardNumber(),
            $this->transaction_action->getCardExpirationDate()
        );

        $this->transaction_action->setAuthorizationCode($response->authorization_code);

        return $response->transaction_id;
    }

    public function makeAuthorizeNet()
    {
        $api = new AuthorizeNetAIM($this->login_key, $this->transaction_key);

        $api->setSandbox(true);

        return $api;
    }

    public function capture()
    {
        $api = $this->makeAuthorizeNet();

        $response = $api->captureOnly(
            $this->transaction_action->getAuthorizationCode(),
            $this->transaction_action->getAmount(),
            $this->transaction_action->getCardNumber(),
            $this->transaction_action->getCardExpirationDate()
        );

        return $response->response_code;
    }
}