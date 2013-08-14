<?php

interface CustomerProfile
{
    public function addPaymentProfile();

    public function addShippingProfile();

    public function removePaymentProfile();

    public function removeShippingProfile();

    public function updateProfile();

    public function deleteProfile();

    public function createTransaction();
}
