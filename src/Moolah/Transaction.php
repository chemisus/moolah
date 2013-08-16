<?php

namespace Moolah;

interface Transaction extends TransactionAction
{
    public function getAuthorizationCode();

    public function getCustomerProfileId();

    public function getPaymentProfileId();

    public function getTransactionAmount();

    public function getTransactionId();
}
