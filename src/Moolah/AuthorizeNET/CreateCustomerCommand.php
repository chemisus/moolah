<?php

namespace Moolah\AuthorizeNET;

use AuthorizeNetCIM;
use AuthorizeNetCustomer;
use Moolah\Customer;
use Moolah\Exception\MoolahException;

class CreateCustomerCommand
{
    private $customer;

    private $transaction_key;

    private $login_key;

    public function __construct($login_key, $transaction_key, Customer $customer)
    {
        $this->transaction_key = $transaction_key;
        $this->login_key       = $login_key;
        $this->customer        = $customer;
    }

    public function execute()
    {

        $customerProfile                     = new AuthorizeNetCustomer();
        $customerProfile->merchantCustomerId = $this->customer->getCustomerId();

        $request = new AuthorizeNetCIM($this->login_key, $this->transaction_key);

        $response = $request->createCustomerProfile($customerProfile);

        if ($response->getResultCode() === 'Error') {
            throw new MoolahException($response->getErrorMessage());
        }

        $new_customer_id = $response->getCustomerProfileId();

        $this->customer->setCustomerProfileId($new_customer_id);
    }
}