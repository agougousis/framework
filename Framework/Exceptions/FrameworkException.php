<?php

namespace Bespoke\Exceptions;

/**
 * A parent class for 4xx exceptions that we throw in the framework code in order to notify the user about
 * something that he did wrong.
 */
abstract class FrameworkException extends \Exception
{
    const STATUS_CODE = 500;

    public function getStatusCode()
    {
        return static::STATUS_CODE;
    }
}
