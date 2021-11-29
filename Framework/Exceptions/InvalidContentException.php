<?php

namespace Bespoke\Exceptions;

class InvalidContentException extends FrameworkException
{
    const DEFAULT_MESSAGE = 'Your request contains invalid data format!';

    const STATUS_CODE = 400;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::STATUS_CODE, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
