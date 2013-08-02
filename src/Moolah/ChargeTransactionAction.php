<?php

namespace Moolah;

interface ChargeTransactionAction extends TransactionAction
{

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