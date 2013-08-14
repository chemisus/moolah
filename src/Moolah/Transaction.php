<?php

namespace Moolah;

interface Transaction
{
    public function getAmount();

    public function getTransactionId();

    public function setTransactionId($transaction_id);
}