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

    /**
     *
     * @param $login_key
     * @param $transaction_key
     */
    public function __construct($login_key, $transaction_key)
    {
        $this->login_key       = $login_key;
        $this->transaction_key = $transaction_key;
        $this->request         = new AuthorizeNetCIM($this->login_key, $this->transaction_key);
    }

    /**
     * @param CustomerProfile $customer_profile
     * @throws Exception\MoolahException
     */
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

    /**
     * @param CustomerProfile $customer
     * @throws Exception\MoolahException
     */
    public function retrieveCustomerProfile(CustomerProfile $customer)
    {
        $response = $this->request->getCustomerProfile($customer->getCustomerProfileId());

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
    }

    /**
     * @param ChargeTransaction $transaction
     * @throws Exception\MoolahException
     */
    public function authorizeCustomerTransaction(ChargeTransaction $transaction)
    {
        // request a new transaction.
        $t = new AuthorizeNetTransaction();

        $t->amount                   = $transaction->getTransactionAmount();
        $t->customerProfileId        = $transaction->getCustomerProfileId();
        $t->customerPaymentProfileId = $transaction->getPaymentProfileId();

        // set transaction to pending.
        $transaction->setTransactionState(1);

        $response = $this->request->createCustomerProfileTransaction("AuthOnly", $t);

        $transaction->setTransactionStatus($response->getTransactionResponse()->response_code);

        $transaction->setTransactionResponseCode($response->getTransactionResponse()->response_reason_code);

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }

        // set the transaction id.
        $transaction->setTransactionID($response->getTransactionResponse()->transaction_id);

        // set the authorization code.
        $transaction->setAuthorizationCode($response->getTransactionResponse()->authorization_code);

        // move to a new state... i suggest anywhere but florida.
        $transaction->setTransactionState(2);

        var_dump($response);
    }

    /**
     * @param ChargeTransaction $transaction
     * @throws Exception\MoolahException
     */
    public function captureCustomerTransaction(ChargeTransaction $transaction)
    {
        // try to capture the payment.
        $t                           = new AuthorizeNetTransaction();
        $t->approvalCode             = $transaction->getAuthorizationCode();
        $t->amount                   = $transaction->getTransactionAmount();
        $t->customerProfileId        = $transaction->getCustomerProfileId();
        $t->customerPaymentProfileId = $transaction->getPaymentProfileId();
        $response                    = $this->request->createCustomerProfileTransaction("CaptureOnly", $t);

        $transaction->setTransactionStatus($response->getTransactionResponse()->response_code);

        $transaction->setTransactionResponseCode($response->getTransactionResponse()->response_reason_code);

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }

        // set the transaction status.

        // move to a new state...
        $transaction->setTransactionState(2);

        var_dump($response);
    }

    /**
     * @param ChargeTransaction $transaction
     * @throws Exception\MoolahException
     */
    public function createCustomerTransaction(ChargeTransaction $transaction)
    {
        // request a new transaction.
        $t = new AuthorizeNetTransaction();

        $t->amount                   = $transaction->getTransactionAmount();
        $t->customerProfileId        = $transaction->getCustomerProfileId();
        $t->customerPaymentProfileId = $transaction->getPaymentProfileId();

        // set transaction to pending.
        $transaction->setTransactionState(1);

        $response = $this->request->createCustomerProfileTransaction("AuthCapture", $t);

        $transaction->setTransactionStatus($response->getTransactionResponse()->response_code);

        $transaction->setTransactionResponseCode($response->getTransactionResponse()->response_reason_code);

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }

        // set the transaction id.
        $transaction->setTransactionID($response->getTransactionResponse()->transaction_id);

        // set the authorization code.
        $transaction->setAuthorizationCode($response->getTransactionResponse()->authorization_code);

        // move to a new state... i suggest anywhere but florida.
        $transaction->setTransactionState(2);

        var_dump($response);
    }

    /**
     * @param Transaction $transaction
     * @throws Exception\MoolahException
     */
    public function voidCustomerTransaction(Transaction $transaction)
    {
        $transaction->setTransactionState(1);

        $t = new AuthorizeNetTransaction;

        $t->transId = $transaction->getTransactionId();

        $response = $this->request->createCustomerProfileTransaction("Void", $t);

        $transaction->setTransactionStatus($response->getTransactionResponse()->response_code);

        $transaction->setTransactionResponseCode($response->getTransactionResponse()->response_reason_code);

        if ($response->getMessageCode() !== "I00001") {
            $transaction->setTransactionStatus(1);

            throw new MoolahException($response->getMessageText());
        }

        // set the transaction id.
        $transaction->setTransactionID($response->getTransactionResponse()->transaction_id);

        $transaction->setTransactionState(2);
    }

    /**
     * @param Transaction $transaction
     * @throws \Exception
     */
    public function refundCustomerTransaction(Transaction $transaction)
    {
        $transaction->setTransactionState(1);

        $t = new AuthorizeNetTransaction;

        $t->customerProfileId = $transaction->getCustomerProfileId();
        $t->customerPaymentProfileId = $transaction->getPaymentProfileId();
        $t->transId = $transaction->getTransactionId();
        $t->amount = $transaction->getTransactionAmount();

        $response = $this->request->createCustomerProfileTransaction("Refund", $t);

        $transaction->setTransactionStatus($response->getTransactionResponse()->response_code);

        $transaction->setTransactionResponseCode($response->getTransactionResponse()->response_reason_code);

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }

        $transaction->setTransactionState(2);
    }

    /**
     * @param CustomerProfile $customer_profile
     * @throws Exception\MoolahException
     */
    public function deleteCustomerProfile(CustomerProfile $customer_profile)
    {
        $response = $this->request->deleteCustomerProfile($customer_profile->getCustomerProfileId());

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
    }

    /**
     * @param PaymentProfile $payment_profile
     * @param $card_number
     * @param $card_expiration
     * @throws Exception\MoolahException
     */
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

    /**
     * @param PaymentProfile $payment_profile
     * @throws Exception\MoolahException
     */
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

    /**
     * @param CustomerProfile $customer_profile
     * @throws Exception\MoolahException
     */
    public function updateCustomerProfile(CustomerProfile $customer_profile)
    {
        $c = new AuthorizeNetCustomer();

        $c->merchantCustomerId = $customer_profile->getCustomerId();

        $response = $this->request->updateCustomerProfile($customer_profile->getCustomerProfileId(), $c);

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
    }

    /**
     * @param PaymentProfile $payment_profile
     * @param $card_number
     * @param $card_expiration
     * @throws Exception\MoolahException
     */
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
