<?php

namespace Moolah;

interface CustomerProfile
{
    public function getCustomerId();

    public function getCustomerProfileId();

    public function setCustomerProfileId($customer_profile_id);
}