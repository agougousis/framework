<?php

namespace Bespoke\Exceptions;

class RouteNotFoundException extends FrameworkException
{
    const DEFAULT_MESSAGE = 'Not found!';

    const STATUS_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::STATUS_CODE, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
