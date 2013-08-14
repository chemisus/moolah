<?php

namespace Moolah;

interface PaymentProfile
{
    public function getCustomerProfileId();

    public function getPaymentProfileId();

    public function setPaymentProfileId($payment_profile_id);
}