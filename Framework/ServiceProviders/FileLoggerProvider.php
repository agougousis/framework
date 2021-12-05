<?php

namespace Bespoke\ServiceProviders;

use App\Components\Config;
use Bespoke\Components\Container;
use Bespoke\Services\FileLogger;
use Bespoke\Services\MonologLogger;
use Psr\Log\LoggerInterface;


class FileLoggerProvider
{
    private static $isSingleton = true;

    public static function isSingleton()
    {
        return self::$isSingleton;
    }

    public static function build(Container $container) : LoggerInterface
    {
        $logFileDirectory = Config::get('app.loggers.file.directory');

        if(!file_exists($logFileDirectory)) {
            mkdir($logFileDirectory, 0700, true);
        }

        return new FileLogger($logFileDirectory);
    }
}
