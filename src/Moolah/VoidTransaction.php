<?php

namespace Moolah;

interface VoidTransaction extends Transaction
{

    public function startedVoid();

    public function finishedVoid($response_code, $response_reason_code);
}
