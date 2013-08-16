<?php

namespace Moolah;

interface AuthorizeCaptureTransaction extends Transaction
{

    public function startedAuthCapture();

    public function finishedAuthCapture($transaction_id, $authorization_code, $response_code, $response_reason_code);
}
