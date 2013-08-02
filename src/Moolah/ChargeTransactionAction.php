<?php

namespace Moolah;

interface ChargeTransactionAction extends TransactionAction
{

    public function getAmount();

    public function getCardNumber();

    public function getCardExpirationDate();

    public function getAuthorizationCode();

    public function setAuthorizationCode($value);
}