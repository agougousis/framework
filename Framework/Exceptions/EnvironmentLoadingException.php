<?php

namespace Bespoke\Exceptions;

class EnvironmentLoadingException extends FrameworkException
{
    const DEFAULT_MESSAGE = 'There was an error while loading environment variables.';

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::STATUS_CODE, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
