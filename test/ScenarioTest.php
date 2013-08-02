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

    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }

    public function testChargeCommandMocked()
    {
        $payment_transaction = Mockery::mock('Moolah\PaymentTransaction');
        $transaction_action  = Mockery::mock('Moolah\ChargeTransactionAction');

        $authorization_code = 'authorization_code';
        $transaction_id     = 'transaction_id';
        $response_code      = 'response_code';

        $response                     = Mockery::mock();
        $response->authorization_code = $authorization_code;
        $response->transaction_id     = $transaction_id;
        $response->response_code      = $response_code;

        $api = Mockery::mock();
        $api->shouldReceive('authorizeOnly')->once()->andReturn($response);
        $api->shouldReceive('captureOnly')->once()->andReturn($response);

        $payment_transaction->shouldReceive('setTransactionID')->with(null)->once();
        $payment_transaction->shouldReceive('setTransactionID')->with($transaction_id)->once();
        $transaction_action->shouldReceive('getAmount')->twice();
        $transaction_action->shouldReceive('getCardNumber')->twice();
        $transaction_action->shouldReceive('getCardExpirationDate')->twice();
        $transaction_action->shouldReceive('getAuthorizationCode')->once();
        $transaction_action->shouldReceive('setAuthorizationCode')->with($authorization_code)->once();
        $transaction_action->shouldReceive('setResponseCode')->with($response_code)->once();

        $charge_command = Mockery::mock(
            'Moolah\AuthorizeNET\ChargeCommand',
            [
                $payment_transaction,
                $transaction_action,
                $this->login_key,
                $this->transaction_key
            ]
        );

        $charge_command->shouldDeferMissing();
        $charge_command->shouldReceive('makeAuthorizeNet')->twice()->andReturn($api);

        $charge_command->execute();
    }

    public function testChargeTransaction()
    {
        $amount               = rand(1, 99999);
        $card_number          = '4007000000027';
        $card_expiration_date = '04/17';

        $transaction_action = new SimpleChargeTransaction($amount, $card_number, $card_expiration_date);

        $payment_transaction = new SimplePaymentTransaction();

        $charge_command = new ChargeCommand(
            $payment_transaction,
            $transaction_action,
            $this->login_key,
            $this->transaction_key
        );

        $charge_command->execute();

        $this->assertNotNull($payment_transaction->getTransactionID());
        $this->assertNotNull($transaction_action->getAuthorizationCode());
        $this->assertEquals('1', $transaction_action->getResponseCode());
        $this->assertFalse($transaction_action->isPending());
        $this->assertEquals('CHARGE', $transaction_action->getTransactionType());
    }
}
