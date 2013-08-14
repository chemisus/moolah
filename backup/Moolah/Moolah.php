<?php

namespace Moolah;

use Moolah\AuthorizeNET\ChargeCustomerCommand;

class Moolah
{

    private $login_key;
    private $transaction_key;

    public function __construct($login_key, $transaction_key)
    {
        $this->login_key       = $login_key;
        $this->transaction_key = $transaction_key;
    }

    /**
     * Creates a new customer profile on authorize.net and stores the new customer profile id in the given customer.
     *
     * @param Customer $customer
     * @throws MoolahException
     */
    public function createCustomerProfile(CustomerProfile $customer)
    {
        $customerProfile                     = new AuthorizeNetCustomer();
        $customerProfile->merchantCustomerId = $customer->getCustomerId();

        $request = new AuthorizeNetCIM($this->login_key, $this->transaction_key);

        $response = $request->createCustomerProfile($customerProfile);

        if ($response->getResultCode() === 'Error') {
            throw new MoolahException($response->getErrorMessage());
        }

        $new_customer_id = $response->getCustomerProfileId();

        $this->customer->setCustomerProfileId($new_customer_id);
    }

    public function chargeCustomerProfile(CustomerProfile $customer, PaymentTransaction $payment_transaction, TransactionAction $transaction_action)
    {
        new ChargeCustomerCommand(
            $this->login_key,
            $this->transaction_key,
            $payment_transaction,
            $transaction_action
        );
    }

}