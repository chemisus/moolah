<?php

namespace Test\Chemisus\Moolah;

use Mockery;
use Moolah\Moolah;
use Moolah\ProcessPaymentCommand;
use PHPUnit_Framework_TestCase;
use Moolah\TestTransaction;
use Moolah\TestCustomerProfile;
use Moolah\TestPaymentProfile;

class ScenarioTest extends PHPUnit_Framework_TestCase
{

    private $login_key = '8cR84FXGvC7';

    private $transaction_key = '3839sCxWg5hx9Y3k';

    private $card_number = '4007000000027';

    private $card_expiration_date = '2017-01';

    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }

    public function testCreateCustomerProfile()
    {
        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $customer_id = null;

        $customer = Mockery::mock('Moolah\CustomerProfile');

        $customer->shouldReceive('getCustomerId')->andReturn(time() . rand(10, 99));

        $customer->shouldReceive('setCustomerProfileId')->andReturnUsing(
            function ($value) use (&$customer_id) {
                $customer_id = $value;
            }
        );

        $moolah->createCustomerProfile($customer);

        $this->assertNotEmpty($customer_id);
    }

    public function testRetrieveCustomerProfile()
    {
        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $customer = Mockery::mock('Moolah\CustomerProfile');

        $customer->shouldReceive('getCustomerProfileId')->andReturn('20314281');

        $moolah->retrieveCustomerProfile($customer);
    }

    public function testCreateCustomerTransaction()
    {
        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $transaction_id     = null;
        $transaction_state  = null;
        $transaction_status = null;
        $authorization_code = null;

        $payment_profile = Mockery::mock('Moolah\PaymentProfile');
        $transaction     = Mockery::mock('Moolah\Transaction');

        $payment_profile->shouldReceive('getCustomerProfileId')->andReturn('20314281');
        $payment_profile->shouldReceive('getPaymentProfileId')->andReturn('18602036');

        $transaction->shouldReceive('getTransactionAmount')->andReturn(rand(1, 99999));
        $transaction->shouldReceive('setTransactionId')->andReturnUsing(
            function ($value) use (&$transaction_id) {
                $transaction_id = $value;
            }
        );

        $transaction->shouldReceive('getAuthorizationCode')->andReturnUsing(
            function () use (&$authorization_code) {
                return $authorization_code;
            }
        );

        $transaction->shouldReceive('setAuthorizationCode')->andReturnUsing(
            function ($value) use (&$authorization_code) {
                $authorization_code = $value;
            }
        );

        $transaction->shouldReceive('setTransactionState')->andReturnUsing(
            function ($value) use (&$transaction_state) {
                $transaction_state = $value;
            }
        );

        $transaction->shouldReceive('setTransactionStatus')->andReturnUsing(
            function ($value) use (&$transaction_status) {
                $transaction_status = $value;
            }
        );

        $moolah->createCustomerTransaction($transaction);

        $this->assertNotEmpty($transaction_id);
    }

    public function testVoidCustomerTransaction()
    {
        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $payment_profile = Mockery::mock('Moolah\PaymentProfile');
        $transaction     = Mockery::mock('Moolah\Transaction');

        $transaction_id     = null;
        $transaction_state  = null;
        $transaction_status = null;
        $authorization_code = null;

        $payment_profile->shouldReceive('getCustomerProfileId')->andReturn('20314281');
        $payment_profile->shouldReceive('getPaymentProfileId')->andReturn('18602036');

        $transaction->shouldReceive('getTransactionAmount')->andReturn(rand(1, 99999));
        $transaction->shouldReceive('setTransactionId')->andReturnUsing(
            function ($value) use (&$transaction_id) {
                $transaction_id = $value;
            }
        );

        $transaction->shouldReceive('getTransactionId')->andReturnUsing(
            function () use (&$transaction_id) {
                return $transaction_id;
            }
        );

        $transaction->shouldReceive('getAuthorizationCode')->andReturnUsing(
            function () use (&$authorization_code) {
                return $authorization_code;
            }
        );

        $transaction->shouldReceive('setAuthorizationCode')->andReturnUsing(
            function ($value) use (&$authorization_code) {
                $authorization_code = $value;
            }
        );

        $transaction->shouldReceive('setTransactionState')->andReturnUsing(
            function ($value) use (&$transaction_state) {
                $transaction_state = $value;
            }
        );

        $transaction->shouldReceive('setTransactionStatus')->andReturnUsing(
            function ($value) use (&$transaction_status) {
                $transaction_status = $value;
            }
        );

        $moolah->createCustomerTransaction($transaction);

        $moolah->voidCustomerTransaction($transaction);
    }

    public function testRefundCustomerTransaction()
    {
        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $customer_profile = new TestCustomerProfile('', '20322219');
        $payment_profile = new TestPaymentProfile($customer_profile, '18608980');

        $transaction = new TestTransaction($payment_profile, '10601.00', '2197104426');

        $moolah->refundCustomerTransaction($transaction);
    }

    public function testDeleteCustomerProfile()
    {
        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $customer_id = null;

        $customer = Mockery::mock('Moolah\CustomerProfile');

        $customer->shouldReceive('getCustomerId')->andReturn(time() . rand(10, 99));

        $customer->shouldReceive('setCustomerProfileId')->andReturnUsing(
            function ($value) use (&$customer_id) {
                $customer_id = $value;
            }
        );

        $customer->shouldReceive('getCustomerProfileId')->andReturnUsing(
            function () use (&$customer_id) {
                return $customer_id;
            }
        );

        $moolah->createCustomerProfile($customer);

        $moolah->deleteCustomerProfile($customer);
    }

    public function testCreatePaymentProfile()
    {
        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $customer_profile_id = null;

        $payment_profile_id = null;

        $customer_profile = Mockery::mock('Moolah\CustomerProfile');

        $customer_profile->shouldReceive('getCustomerId')->andReturn(time() . rand(10, 99));

        $customer_profile->shouldReceive('setCustomerProfileId')->andReturnUsing(
            function ($value) use (&$customer_profile_id) {
                $customer_profile_id = $value;
            }
        );

        $customer_profile->shouldReceive('getCustomerProfileId')->andReturnUsing(
            function () use (&$customer_profile_id) {
                return $customer_profile_id;
            }
        );

        $payment_profile = Mockery::mock('Moolah\PaymentProfile');

        $payment_profile->shouldReceive('getCustomerProfileId')->andReturnUsing(
            function () use (&$customer_profile_id) {
                return $customer_profile_id;
            }
        );

        $payment_profile->shouldReceive('setPaymentProfileId')->andReturnUsing(
            function ($value) use (&$payment_profile_id) {
                $payment_profile_id = $value;
            }
        );

        $moolah->createCustomerProfile($customer_profile);

        $moolah->createPaymentProfile($payment_profile, $this->card_number, $this->card_expiration_date);

        $this->assertNotEmpty($customer_profile_id);
        $this->assertNotEmpty($payment_profile_id);
    }

    public function testRemovePaymentProfile()
    {
        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $customer_profile_id = null;

        $payment_profile_id = null;

        $customer_profile = Mockery::mock('Moolah\CustomerProfile');

        $customer_profile->shouldReceive('getCustomerId')->andReturn(time() . rand(10, 99));

        $customer_profile->shouldReceive('setCustomerProfileId')->andReturnUsing(
            function ($value) use (&$customer_profile_id) {
                $customer_profile_id = $value;
            }
        );

        $customer_profile->shouldReceive('getCustomerProfileId')->andReturnUsing(
            function () use (&$customer_profile_id) {
                return $customer_profile_id;
            }
        );

        $payment_profile = Mockery::mock('Moolah\PaymentProfile');

        $payment_profile->shouldReceive('getCustomerProfileId')->andReturnUsing(
            function () use (&$customer_profile_id) {
                return $customer_profile_id;
            }
        );

        $payment_profile->shouldReceive('setPaymentProfileId')->andReturnUsing(
            function ($value) use (&$payment_profile_id) {
                $payment_profile_id = $value;
            }
        );

        $payment_profile->shouldReceive('getPaymentProfileId')->andReturnUsing(
            function () use (&$payment_profile_id) {
                return $payment_profile_id;
            }
        );

        $moolah->createCustomerProfile($customer_profile);

        $moolah->createPaymentProfile($payment_profile, $this->card_number, $this->card_expiration_date);

        $moolah->removePaymentProfile($payment_profile);
    }

    public function testUpdateCustomerProfile()
    {
        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $customer_profile_id = null;

        $payment_profile_id = null;

        $customer_profile = Mockery::mock('Moolah\CustomerProfile');

        $customer_profile->shouldReceive('getCustomerId')->andReturnUsing(
            function () {
                $value = '11110000' . rand(1000, 9999);

                return $value;
            }
        );

        $customer_profile->shouldReceive('setCustomerProfileId')->andReturnUsing(
            function ($value) use (&$customer_profile_id) {
                $customer_profile_id = $value;
            }
        );

        $customer_profile->shouldReceive('getCustomerProfileId')->andReturnUsing(
            function () use (&$customer_profile_id) {
                return $customer_profile_id;
            }
        );

        $moolah->createCustomerProfile($customer_profile);

        $moolah->updateCustomerProfile($customer_profile);
    }

    public function testUpdatePaymentProfile()
    {

        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $customer_profile_id = null;

        $payment_profile_id = null;

        $customer_profile = Mockery::mock('Moolah\CustomerProfile');

        $customer_profile->shouldReceive('getCustomerId')->andReturn(time() . rand(10, 99));

        $customer_profile->shouldReceive('setCustomerProfileId')->andReturnUsing(
            function ($value) use (&$customer_profile_id) {
                $customer_profile_id = $value;
            }
        );

        $customer_profile->shouldReceive('getCustomerProfileId')->andReturnUsing(
            function () use (&$customer_profile_id) {
                return $customer_profile_id;
            }
        );

        $payment_profile = Mockery::mock('Moolah\PaymentProfile');

        $payment_profile->shouldReceive('getCustomerProfileId')->andReturnUsing(
            function () use (&$customer_profile_id) {
                return $customer_profile_id;
            }
        );

        $payment_profile->shouldReceive('getPaymentProfileId')->andReturnUsing(
            function () use (&$payment_profile_id) {
                return $payment_profile_id;
            }
        );

        $payment_profile->shouldReceive('setPaymentProfileId')->andReturnUsing(
            function ($value) use (&$payment_profile_id) {
                $payment_profile_id = $value;
            }
        );

        $moolah->createCustomerProfile($customer_profile);

        $moolah->createPaymentProfile($payment_profile, $this->card_number, $this->card_expiration_date);

        $moolah->updatePaymentProfile($payment_profile, $this->card_number, '2026-05');

        $this->assertNotEmpty($customer_profile_id);
        $this->assertNotEmpty($payment_profile_id);
    }

    public function testScenario()
    {
        $customer_profile = new TestCustomerProfile(time() . rand(10, 99));

        $payment_profile = new TestPaymentProfile($customer_profile);

        $charge_transaction = new TestTransaction($payment_profile, rand(1, 99999));

        $moolah = new Moolah($this->login_key, $this->transaction_key);

        $moolah->createCustomerProfile($customer_profile);

        $this->assertNotEmpty($customer_profile->getCustomerProfileId());

        $moolah->createPaymentProfile($payment_profile, $this->card_number, $this->card_expiration_date);

        $this->assertNotEmpty($payment_profile->getPaymentProfileId());

        $moolah->authorize($charge_transaction);

        $this->assertNotEmpty($charge_transaction->getTransactionId());
        $this->assertNotEmpty($charge_transaction->getAuthorizationCode());
        $this->assertEquals(3, $charge_transaction->getTransactionState());

        $moolah->capture($charge_transaction);

        $this->assertEquals(2, $charge_transaction->getTransactionState());
    }
}
