<?php

namespace Moolah\AuthorizeNET;

use AuthorizeNetAIM;
use AuthorizeNetCIM;

class StateTemplate
{

    private $login_key;

    private $transaction_key;

    public function __construct($login_key, $transaction_key)
    {
        $this->login_key       = $login_key;
        $this->transaction_key = $transaction_key;
    }

    public function makeAuthorizeNetAIM()
    {
        $api = new AuthorizeNetAIM($this->login_key, $this->transaction_key);

        $api->setSandbox(true);

        return $api;
    }

    public function makeAuthorizeNetCIM()
    {
        $api = new AuthorizeNetCIM($this->login_key, $this->transaction_key);

        $api->setSandbox(true);

        return $api;
    }
}
