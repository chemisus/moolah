<?php

namespace Moolah;

class SimpleChargeTransaction extends SimpleTransactionAction implements ChargeTransactionAction
{

    private $amount;

    private $card_number;

    private $card_expiration_date;

    private $authorization_code;

    public function __construct(
        $amount,
        $card_number,
        $card_expiration_date,
        $authorization_code = null,
        $transaction_type = null,
        $response_code = null
    ) {
        parent::__construct($transaction_type, $response_code);

        $this->amount               = $amount;
        $this->card_number          = $card_number;
        $this->card_expiration_date = $card_expiration_date;
        $this->authorization_code   = $authorization_code;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCardNumber()
    {
        return $this->card_number;
    }

    public function getCardExpirationDate()
    {
        return $this->card_expiration_date;
    }

    public function getAuthorizationCode()
    {
        return $this->authorization_code;
    }

    public function setAuthorizationCode($value)
    {
        $this->authorization_code = $value;
    }

    public function getTransactionType()
    {
        return 'CHARGE';
    }
}