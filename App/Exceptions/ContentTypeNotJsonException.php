<?php

namespace App\Exceptions;

class ContentTypeNotJsonException extends CustomException
{
    const DEFAULT_MESSAGE = 'Invalid request! The content should be JSON-encoded.';

    const STATUS_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::STATUS_CODE, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return self::STATUS_CODE;
    }
}
