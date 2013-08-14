<?php

namespace Moolah;

interface Customer
{
    public function getCustomerId();

    public function getCustomerProfileId();

    public function setCustomerProfileId($value);
}