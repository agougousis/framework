<?php

namespace Bespoke\Exceptions;

abstract class FrameworkException extends \Exception
{
    const STATUS_CODE = 500;

    public function getStatusCode()
    {
        return static::STATUS_CODE;
    }
}
