<?php

namespace Bespoke\Exceptions;

class ContentTypeNotJsonException extends FrameworkException
{
    const DEFAULT_MESSAGE = 'Invalid request! The content should be JSON-encoded.';

    const STATUS_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::STATUS_CODE, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
