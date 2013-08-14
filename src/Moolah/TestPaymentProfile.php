<?php

namespace Moolah;

class TestPaymentProfile implements PaymentProfile
{

    private $customer_profile;

    private $payment_profile_id;

    public function __construct(CustomerProfile $customer_profile, $payment_profile_id = null)
    {
        $this->customer_profile   = $customer_profile;
        $this->payment_profile_id = $payment_profile_id;
    }

    public function getCustomerProfileId()
    {
        return $this->customer_profile->getCustomerProfileId();
    }

    public function getPaymentProfileId()
    {
        return $this->payment_profile_id;
    }

    public function setPaymentProfileId($payment_profile_id)
    {
        $this->payment_profile_id = $payment_profile_id;
    }
}