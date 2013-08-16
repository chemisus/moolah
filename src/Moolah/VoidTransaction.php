<?php

namespace Moolah;

interface VoidTransaction extends TransactionAction
{

    public function startingVoid();

    public function finishedVoid($response_code, $response_reason_code);
}
