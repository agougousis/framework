<?php

namespace Bespoke\ServiceProviders;

use Bespoke\Http\Request;
use Bespoke\Components\Container;

class RequestProvider
{
    private static $isSingleton = true;

    private static $canBeReplaced = false;

    public static function isSingleton()
    {
        return self::$isSingleton;
    }

    public static function canBeReplaced(): bool
    {
        return self::$canBeReplaced;
    }

    public static function build(Container $container) : Request
    {
        return Request::getInstance();
    }
}
