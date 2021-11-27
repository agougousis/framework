<?php

namespace App\Exceptions;

class InvalidRouteDefinitionException extends CustomException
{
    const DEFAULT_MESSAGE = 'Something wrong happened! Please, try again later.';

    const STATUS_CODE = 500;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::STATUS_CODE, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return self::STATUS_CODE;
    }
}
