<?php


namespace Bespoke\Exceptions;


class ResolverException extends FrameworkException
{
    const DEFAULT_MESSAGE = 'Something went wrong during reflection resolving.';

    const STATUS_CODE = 500;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::STATUS_CODE, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
