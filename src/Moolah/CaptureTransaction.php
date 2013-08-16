<?php

namespace Moolah;

interface CaptureTransaction extends Transaction
{

    public function startingCapture();

    public function finishedCapture($transaction_id, $response_code, $response_reason_code);
}
