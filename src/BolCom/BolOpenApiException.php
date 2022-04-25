<?php

namespace BolCom;

class BolOpenApiException extends \Exception
{
    public function __construct($message)
    {
        return parent::__construct('bol.com Open API exception: ' . $message);
    }
}