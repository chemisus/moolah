<?php

namespace Test\Chemisus\Moolah;

use Mockery;
use Moolah\AuthorizeNET\ChargeCommand;
use Moolah\ProcessPaymentCommand;
use Moolah\SimpleChargeTransaction;
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

    public function test()
    {
        $amount              = rand(1, 99999);
        $payment_transaction = new SimplePaymentTransaction();
        $charge_transaction  = new SimpleChargeTransaction(
            $amount,
            $this->card_number,
            $this->card_expiration_date
        );

        $command = new ChargeCommand(
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
    }
}
