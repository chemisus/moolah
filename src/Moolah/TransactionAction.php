<?php

namespace Moolah;

interface TransactionAction
{

    public function isPending();

    public function getTransactionType();

    public function getResponseCode();

    public function setResponseCode($value);
}
