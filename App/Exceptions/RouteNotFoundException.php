<?php

namespace App\Exceptions;

class RouteNotFoundException extends CustomException
{
    const DEFAULT_MESSAGE = 'Not found!';

    const STATUS_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::STATUS_CODE, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return self::STATUS_CODE;
    }
}
