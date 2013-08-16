<?php

namespace Moolah;

use AuthorizeNetCIM;
use AuthorizeNetCustomer;
use AuthorizeNetPaymentProfile;
use AuthorizeNetTD;
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
     * @param AuthorizeTransaction $transaction
     * @throws Exception\MoolahException
     */
    public function authorizeCustomerTransaction(AuthorizeTransaction $transaction)
    {
        $t = new AuthorizeNetTransaction();

        $t->amount                   = $transaction->getTransactionAmount();
        $t->customerProfileId        = $transaction->getCustomerProfileId();
        $t->customerPaymentProfileId = $transaction->getPaymentProfileId();

        $transaction->startingAuthorize();

        $response = $this->request->createCustomerProfileTransaction("AuthOnly", $t);

        $transaction->finishedAuthorize(
            $response->getTransactionResponse()->transaction_id,
            $response->getTransactionResponse()->authorization_code,
            $response->getTransactionResponse()->response_code,
            $response->getTransactionResponse()->response_reason_code
        );

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
    }

    /**
     * @param CaptureTransaction $transaction
     * @throws Exception\MoolahException
     */
    public function captureCustomerTransaction(CaptureTransaction $transaction)
    {
        $t                           = new AuthorizeNetTransaction();
        $t->approvalCode             = $transaction->getAuthorizationCode();
        $t->amount                   = $transaction->getTransactionAmount();
        $t->customerProfileId        = $transaction->getCustomerProfileId();
        $t->customerPaymentProfileId = $transaction->getPaymentProfileId();

        $transaction->startingCapture();

        $response = $this->request->createCustomerProfileTransaction("CaptureOnly", $t);

        $transaction->finishedCapture(
            $response->getTransactionResponse()->transaction_id,
            $response->getTransactionResponse()->response_code,
            $response->getTransactionResponse()->response_reason_code
        );

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
    }

    /**
     * @param AuthorizeCaptureTransaction $transaction
     * @throws Exception\MoolahException
     */
    public function createCustomerTransaction(AuthorizeCaptureTransaction $transaction)
    {
        $t = new AuthorizeNetTransaction();

        $t->amount                   = $transaction->getTransactionAmount();
        $t->customerProfileId        = $transaction->getCustomerProfileId();
        $t->customerPaymentProfileId = $transaction->getPaymentProfileId();

        $transaction->startedAuthCapture();

        $response = $this->request->createCustomerProfileTransaction("AuthCapture", $t);

        $transaction->finishedAuthCapture(
            $response->getTransactionResponse()->transaction_id,
            $response->getTransactionResponse()->authorization_code,
            $response->getTransactionResponse()->response_code,
            $response->getTransactionResponse()->response_reason_code
        );

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
    }

    /**
     * @param VoidTransaction $transaction
     * @throws Exception\MoolahException
     */
    public function voidCustomerTransaction(VoidTransaction $transaction)
    {
        $t = new AuthorizeNetTransaction;

        $t->transId = $transaction->getTransactionId();

        $transaction->startedVoid();

        $response = $this->request->createCustomerProfileTransaction("Void", $t);

        $transaction->finishedVoid(
            $response->getTransactionResponse()->response_code,
            $response->getTransactionResponse()->response_reason_code
        );

        if ($response->getMessageCode() !== "I00001") {
            $transaction->setTransactionStatus(1);

            throw new MoolahException($response->getMessageText());
        }
    }

    /**
     * @param RefundTransaction $transaction
     * @throws Exception\MoolahException
     */
    public function refundCustomerTransaction(RefundTransaction $transaction)
    {
        $t = new AuthorizeNetTransaction;

        $t->customerProfileId        = $transaction->getCustomerProfileId();
        $t->customerPaymentProfileId = $transaction->getPaymentProfileId();
        $t->transId                  = $transaction->getTransactionId();
        $t->amount                   = $transaction->getTransactionAmount();

        $transaction->startedRefund();

        $response = $this->request->createCustomerProfileTransaction("Refund", $t);

        $transaction->finishedRefund(
            $response->getTransactionResponse()->transaction_id,
            $response->getTransactionResponse()->response_code,
            $response->getTransactionResponse()->response_reason_code
        );

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }
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

    public function transactionDetails(Transaction $transaction)
    {
        $request = new AuthorizeNetTD($this->login_key, $this->transaction_key);

        $response = $request->getTransactionDetails($transaction->getTransactionId());

        if ($response->getMessageCode() !== "I00001") {
            throw new MoolahException($response->getMessageText());
        }

        return $response;
    }
}
