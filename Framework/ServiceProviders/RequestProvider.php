<?php

namespace Bespoke\ServiceProviders;

use Bespoke\Http\Request;
use Bespoke\Components\Container;

class RequestProvider
{
    private static $isSingleton = true;

    public static function isSingleton()
    {
        return self::$isSingleton;
    }

    public static function build(Container $container) : Request
    {
        return Request::getInstance();
    }
}
