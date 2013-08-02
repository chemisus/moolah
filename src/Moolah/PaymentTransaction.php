<?php

namespace Moolah;

interface PaymentTransaction
{

    public function getTransactionID();

    public function setTransactionID($value);
}
