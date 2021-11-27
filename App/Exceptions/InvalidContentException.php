<?php

namespace App\Exceptions;

class InvalidContentException extends CustomException
{
    const DEFAULT_MESSAGE = 'Your request contains invalid data format!';

    const STATUS_CODE = 400;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::STATUS_CODE, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return self::STATUS_CODE;
    }
}
