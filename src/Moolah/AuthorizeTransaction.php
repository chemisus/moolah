<?php

namespace Moolah;

interface AuthorizeTransaction extends Transaction
{

    public function startingAuthorize();

    public function finishedAuthorize($transaction_id, $authorization_code, $response_code, $response_reason_code);

    public function errorAuthorize($response_code, $response_reason_code);
}
