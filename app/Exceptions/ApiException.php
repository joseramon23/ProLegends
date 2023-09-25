<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected $statusCode;

    public function __construct($message, $statusCode = 500)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        $this->message = $message;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}