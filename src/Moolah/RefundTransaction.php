<?php

namespace Moolah;

interface RefundTransaction extends Transaction
{

    public function startingRefund();

    public function finishedRefund($transaction_id, $response_code, $response_reason_code);

    public function errorRefund($response_code, $response_reason_code);
}
