<?php

namespace Moolah\AuthorizeNET;

use AuthorizeNetCIM;
use Moolah\CustomerProfile;

class RetrieveCustomerProfileCommand
{
    private $customer;

    private $transaction_key;

    private $login_key;

    public function __construct($login_key, $transaction_key, CustomerProfile $customer)
    {
        $this->transaction_key = $transaction_key;
        $this->login_key       = $login_key;
        $this->customer        = $customer;
    }

    public function execute()
    {
        $request = new AuthorizeNetCIM($this->login_key, $this->transaction_key);

        $response = $request->getCustomerProfile($this->customer->getCustomerProfileId());

        var_dump($response);
    }
}
