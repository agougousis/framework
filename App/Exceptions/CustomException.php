<?php

namespace App\Exceptions;

abstract class CustomException extends \Exception
{
    private $statusCode;

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
