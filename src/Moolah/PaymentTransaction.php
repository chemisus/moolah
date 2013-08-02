<?php

namespace Moolah;

interface PaymentTransaction
{

    /**
     * Get the ID of the transaction as stored on the remote server.
     *
     * @return mixed
     */
    public function getTransactionID();

    /**
     * Sets the transaction ID that was returned from the remote server.
     *
     * @param $value
     *
     * @return mixed
     */
    public function setTransactionID($value);
}
