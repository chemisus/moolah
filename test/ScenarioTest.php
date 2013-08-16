<?php

namespace Test\Moolah;

use Mockery;
use Moolah\Moolah;
use Moolah\ProcessPaymentCommand;
use Moolah\TestCustomerProfile;
use Moolah\TestPaymentProfile;
use Moolah\TestTransaction;
use Moolah\TestVoidTransaction;
use PHPUnit_Framework_TestCase;

class ScenarioTest extends PHPUnit_Framework_TestCase
{

    private $login_key = '8cR84FXGvC7';

    private $transaction_key = '3839sCxWg5hx9Y3k';

    private $card_number = '4007000000027';

    private $card_expiration_date = '2017-01';

    private $customer_profile_id = '20314281';

    private $payment_profile_id = '18602036';

    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }

    public function testCreateCustomerProfile()
    {
    }

    public function testRetrieveCustomerProfile()
    {
    }

    public function testCreateCustomerTransaction()
    {
    }

    public function testVoidCustomerTransaction()
    {
    }

    public function testRefundCustomerTransaction()
    {
        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $customer_profile = new TestCustomerProfile('', $this->customer_profile_id);

        $payment_profile = new TestPaymentProfile($customer_profile, $this->payment_profile_id);

        $transaction_id = '2197153463';

        $refund_transaction = new TestTransaction($payment_profile, 14, $transaction_id);

        $moolah->refundCustomerTransaction($refund_transaction);

        $this->assertNotEquals($transaction_id, $refund_transaction->getTransactionId());

        $void_transaction = new TestTransaction($payment_profile, 0, $refund_transaction->getTransactionId());

        $moolah->voidCustomerTransaction($void_transaction);
    }

    public function testDeleteCustomerProfile()
    {
    }

    public function testCreatePaymentProfile()
    {
    }

    public function testRemovePaymentProfile()
    {
    }

    public function testUpdateCustomerProfile()
    {
    }

    public function testUpdatePaymentProfile()
    {
    }

    public function testScenario()
    {
        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $customer_profile = new TestCustomerProfile(time() . rand(10, 99));

        $payment_profile = new TestPaymentProfile($customer_profile);

        $amount = rand(1, 99999);

        $authorize_transaction = new TestTransaction($payment_profile, $amount);

        $moolah->createCustomerProfile($customer_profile);

        $moolah->createPaymentProfile($payment_profile, $this->card_number, $this->card_expiration_date);

        $moolah->authorizeCustomerTransaction($authorize_transaction);

        $this->assertNotEmpty($authorize_transaction->getAuthorizationCode());
        $this->assertNotEmpty($authorize_transaction->getTransactionId());

        $moolah->transactionDetails($authorize_transaction);

        $capture_transaction = new TestTransaction(
            $payment_profile,
            $amount,
            $authorize_transaction->getTransactionId(),
            $authorize_transaction->getAuthorizationCode()
        );

        $moolah->captureCustomerTransaction($capture_transaction);

        $this->assertNotEmpty($capture_transaction->getAuthorizationCode());
        $this->assertNotEmpty($capture_transaction->getTransactionId());

        $this->assertNotEquals($authorize_transaction->getTransactionId(), $capture_transaction->getTransactionId());

        $moolah->transactionDetails($capture_transaction);

        $void_transaction = new TestVoidTransaction(
            $payment_profile,
            $amount,
            $capture_transaction->getTransactionId()
        );

        $moolah->voidCustomerTransaction($void_transaction);

        $moolah->transactionDetails($capture_transaction);
    }
}
