<?php

namespace Arweave\Cli\Exceptions;

use Exception;

class TransactionNotFoundException extends Exception
{

    private $body;

    public function __construct($message = null, $body,$code=0)
    {
        $this->body=$body;
        parent::__construct($message, $code,null);
    }

    public function getBody(){
        return $this->body;
    }
}
