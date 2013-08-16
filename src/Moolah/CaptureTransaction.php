<?php

namespace Moolah;

interface CaptureTransaction extends Transaction
{

    public function startedCapture();

    public function finishedCapture($transaction_id, $response_code, $response_reason_code);
}
