<?php

namespace Moolah;

interface ChargeTransactionAction extends TransactionAction
{

    /**
     * Get the amount the transaction is for.
     *
     * @return float
     */
    public function getAmount();

    /**
     * Get the card number used for the transaction.
     *
     * @return string
     */
    public function getCardNumber();

    /**
     * Get the card expiration date used for the transaction.
     *
     * @return string
     */
    public function getCardExpirationDate();

    /**
     * Get the authorization code needed to capture the payment.
     *
     * @return string
     */
    public function getAuthorizationCode();

    /**
     * Set the authorization code returned by the server.
     *
     * @param string $value
     *
     * @return null
     */
    public function setAuthorizationCode($value);
}