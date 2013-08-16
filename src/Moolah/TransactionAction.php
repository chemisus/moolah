<?php

namespace Moolah;

interface TransactionAction
{
    public function getReferenceId();

    public function getTransactionState();

    public function getTransactionStatus();
}