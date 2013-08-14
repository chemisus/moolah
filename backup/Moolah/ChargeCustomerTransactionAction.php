<?php

namespace Moolah;

interface ChargeCustomerTransactionAction extends ChargeTransactionAction
{

    /**
     * Get the id of the customer profile to use.
     *
     * @return string
     */
    public function getCustomerProfileID();

    /**
     * Get the id of the payment profile to use.
     *
     * @return string
     */
    public function getCustomerPaymentProfileID();

    /**
     * Get the id of the shipping profile to use.
     *
     * @return string
     */
    public function getCustomerShippingProfileID();
}
