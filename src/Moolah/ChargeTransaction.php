<?php

namespace Moolah;

interface ChargeTransaction extends Transaction
{

    public function getAuthorizationCode();

    public function setAuthorizationCode($value);
}
