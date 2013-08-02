<?php

namespace Moolah;

interface TransactionAction
{

    public function isPending();

    public function getTransactionType();

    public function getTransactionActionStatus();

    public function setTransactionActionStatus($value);
}
