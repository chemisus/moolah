<?php

namespace Moolah;

interface ChargeCardTransactionAction extends ChargeTransactionAction
{

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
}