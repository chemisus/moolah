<?php

namespace Moolah;

use AuthorizeNetCIM;
use AuthorizeNetCustomer;
use AuthorizeNetPaymentProfile;
use AuthorizeNetTransaction;
use Moolah\Exception\MoolahException;

class Moolah
{

    private $login_key;
    private $transaction_key;
    private $request;

    public function __construct($login_key, $transaction_key)
    {
        $this->login_key       = $login_key;
        $this->transaction_key = $transaction_key;
        $this->request         = new AuthorizeNetCIM($this->login_key, $this->transaction_key);
    }

    public function createCustomerProfile(CustomerProfile $customer_profile)
    {
        $c = new AuthorizeNetCustomer();

        $c->merchantCustomerId = $customer_profile->getCustomerId();

        $response = $this->request->createCustomerProfile($c);

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getErrorMessage());
        }

        $customer_profile->setCustomerProfileId($response->getCustomerProfileId());
    }

    public function retrieveCustomerProfile(CustomerProfile $customer)
    {
        $response = $this->request->getCustomerProfile($customer->getCustomerProfileId());

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
    }

    public function createCustomerTransaction(PaymentProfile $payment_profile, Transaction $transaction)
    {
        $t                           = new AuthorizeNetTransaction;
        $t->amount                   = $transaction->getAmount();
        $t->customerProfileId        = $payment_profile->getCustomerProfileId();
        $t->customerPaymentProfileId = $payment_profile->getPaymentProfileId();

        $response = $this->request->createCustomerProfileTransaction("AuthCapture", $t);

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }

        $transaction_response = $response->getTransactionResponse();

        $transaction->setTransactionId($transaction_response->transaction_id);
    }

    public function voidCustomerTransaction(Transaction $transaction)
    {
        $t = new AuthorizeNetTransaction;

        $t->transId = $transaction->getTransactionId();

        $response = $this->request->createCustomerProfileTransaction("Void", $t);

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
    }

    public function refundCustomerTransaction(Transaction $transaction)
    {
        throw new \Exception('not implemented yet');
    }

    public function deleteCustomerProfile(CustomerProfile $customer_profile)
    {
        $response = $this->request->deleteCustomerProfile($customer_profile->getCustomerProfileId());

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
    }

    public function createPaymentProfile(PaymentProfile $payment_profile, $card_number, $card_expiration)
    {
        $pp = new AuthorizeNetPaymentProfile;

        $pp->payment->creditCard->cardNumber     = $card_number;
        $pp->payment->creditCard->expirationDate = $card_expiration;

        $response = $this->request->createCustomerPaymentProfile($payment_profile->getCustomerProfileId(), $pp);

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }

        $payment_profile->setPaymentProfileId($response->getPaymentProfileId());
    }

    public function removePaymentProfile(PaymentProfile $payment_profile)
    {
        $response = $this->request->deleteCustomerPaymentProfile(
            $payment_profile->getCustomerProfileId(),
            $payment_profile->getPaymentProfileId()
        );

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
    }

    public function updateCustomerProfile(CustomerProfile $customer_profile)
    {
        $c = new AuthorizeNetCustomer();

        $c->merchantCustomerId = $customer_profile->getCustomerId();

        $response = $this->request->updateCustomerProfile($customer_profile->getCustomerProfileId(), $c);

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
    }

    public function updatePaymentProfile(PaymentProfile $payment_profile, $card_number, $card_expiration)
    {
        $pp = new AuthorizeNetPaymentProfile;

        $pp->payment->creditCard->cardNumber     = $card_number;
        $pp->payment->creditCard->expirationDate = $card_expiration;

        $response = $this->request->updateCustomerPaymentProfile(
            $payment_profile->getCustomerProfileId(),
            $payment_profile->getPaymentProfileId(),
            $pp
        );

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
    }
}
