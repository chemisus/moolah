<?php

namespace Moolah;

interface TransactionAction
{

    /**
     * Gets the type of the transaction.
     *
     * @return mixed
     */
    public function getTransactionType();

    /**
     * Gets the state of the transaction.
     *
     * @return integer
     */
    public function getTransactionState();

    /**
     * Sets the state of the transaction.
     *
     * @param integer $value
     *
     * @return integer
     */
    public function setTransactionState($value);

    /**
     * Gets the status of the transaction.
     *
     * @return mixed
     */
    public function getTransactionStatus();

    /**
     * Sets the status of the transaction.
     *
     * @param integer $value
     *
     * @return mixed
     */
    public function setTransactionStatus($value);
}
