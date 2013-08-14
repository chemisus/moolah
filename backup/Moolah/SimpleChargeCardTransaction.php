<?php

namespace Moolah;

class SimpleChargeCardTransaction extends SimpleTransactionAction implements ChargeCardTransactionAction
{

    private $amount;

    private $card_number;

    private $card_expiration_date;

    private $authorization_code;

    private $transaction_state;

    public function __construct(
        $amount,
        $card_number,
        $card_expiration_date,
        $transaction_state = 1,
        $authorization_code = null,
        $transaction_status = null
    ) {
        parent::__construct($transaction_status);

        $this->amount                   = $amount;
        $this->card_number              = $card_number;
        $this->card_expiration_date     = $card_expiration_date;
        $this->authorization_code       = $authorization_code;
        $this->transaction_state = $transaction_state;
    }

    /**
     * Gets the type of the transaction.
     *
     * @return mixed
     */
    public function getTransactionType()
    {
        return 'CHARGE';
    }

    /**
     * Gets the state of the transaction.
     *
     * @return integer
     */
    public function getTransactionState()
    {
        return $this->transaction_state;
    }

    /**
     * Sets the state of the transaction.
     *
     * @param integer $value
     *
     * @return integer
     */
    public function setTransactionState($value)
    {
        $this->transaction_state = $value;
    }

    /**
     * Get the amount the transaction is for.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get the card number used for the transaction.
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * Get the card expiration date used for the transaction.
     *
     * @return string
     */
    public function getCardExpirationDate()
    {
        return $this->card_expiration_date;
    }

    /**
     * Get the authorization code needed to capture the payment.
     *
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorization_code;
    }

    /**
     * Set the authorization code returned by the server.
     *
     * @param string $value
     *
     * @return null
     */
    public function setAuthorizationCode($value)
    {
        $this->authorization_code = $value;
    }
}