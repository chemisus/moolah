<?php

namespace Moolah;

interface Transaction
{
    public function getCustomerProfileId();

    public function getPaymentProfileId();

    public function getTransactionAmount();

    public function getTransactionId();

    public function setTransactionId($transaction_id);

    public function getTransactionState();

    public function setTransactionState($value);

    public function getTransactionStatus();

    public function setTransactionStatus($value);

    public function setTransactionResponseCode($value);
}
