<?php

namespace Test\Chemisus\Moolah;

use Mockery;
use Moolah\AuthorizeNET\ChargeCardCommand;
use Moolah\AuthorizeNET\ChargeCustomerCommand;
use Moolah\AuthorizeNET\CreateCustomerCommand;
use Moolah\ProcessPaymentCommand;
use Moolah\SimpleChargeCardTransaction;
use Moolah\SimpleChargeCustomerTransaction;
use Moolah\SimpleCustomer;
use Moolah\SimplePaymentTransaction;
use PHPUnit_Framework_TestCase;

class ScenarioTest extends PHPUnit_Framework_TestCase
{

    private $login_key = '8cR84FXGvC7';

    private $transaction_key = '3839sCxWg5hx9Y3k';

    private $card_number = '4007000000027';

    private $card_expiration_date = '04/17';

    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }

    public function testChargeCard()
    {
        $amount              = rand(1, 99999);
        $payment_transaction = new SimplePaymentTransaction();
        $charge_transaction  = new SimpleChargeCardTransaction(
            $amount,
            $this->card_number,
            $this->card_expiration_date
        );

        $command = new ChargeCardCommand(
            $this->login_key,
            $this->transaction_key,
            $payment_transaction,
            $charge_transaction
        );

        $command->execute();

        $this->assertEquals('1', $charge_transaction->getTransactionStatus());
        $this->assertEquals(2, $charge_transaction->getTransactionState());
        $this->assertNotNull($charge_transaction->getAuthorizationCode());
        $this->assertNotNull($payment_transaction->getTransactionID());
        $this->assertEquals('CHARGE', $charge_transaction->getTransactionType());
    }

    public function testChargeCustomer()
    {
        $amount                      = rand(1, 99999);
        $customer_profile_id         = '20147498';
        $customer_payment_profile_id = '18429424';
        $customer_shipping_profile_id = '18630558';

        $payment_transaction = new SimplePaymentTransaction();
        $charge_transaction  = new SimpleChargeCustomerTransaction(
            $amount,
            $customer_profile_id,
            $customer_payment_profile_id,
            $customer_shipping_profile_id
        );

        $command = new ChargeCustomerCommand(
            $this->login_key,
            $this->transaction_key,
            $payment_transaction,
            $charge_transaction
        );

        $command->execute();

        $this->assertEquals('CHARGE', $charge_transaction->getTransactionType());
        $this->assertNotNull($charge_transaction->getAuthorizationCode());
        $this->assertNotNull($payment_transaction->getTransactionID());
        $this->assertEquals(2, $charge_transaction->getTransactionState());
        $this->assertEquals('1', $charge_transaction->getTransactionStatus());
    }

    public function testCreateCustomerProfile()
    {
        $customer = new SimpleCustomer(time().rand(10,99));

        $create_customer = new CreateCustomerCommand($this->login_key, $this->transaction_key, $customer);

        $create_customer->execute();
    }
}
