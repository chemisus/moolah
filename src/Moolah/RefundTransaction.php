<?php

namespace Moolah;

interface RefundTransaction extends Transaction
{

    public function startedRefund();

    public function finishedRefund($transaction_id, $response_code, $response_reason_code);
}
