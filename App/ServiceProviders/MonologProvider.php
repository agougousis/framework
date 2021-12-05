<?php

namespace App\ServiceProviders;

use Bespoke\Components\Container;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\SyslogHandler;
use Monolog\Logger as MonologLogger;
use Psr\Log\LoggerInterface;
use Bespoke\Components\Config;

class MonologProvider
{
    private static $isSingleton = true;

    private static $canBeReplaced = true;

    public static function isSingleton()
    {
        return self::$isSingleton;
    }

    public static function canBeReplaced(): bool
    {
        return self::$canBeReplaced;
    }

    public static function build(Container $container) : LoggerInterface
    {
        $monologTarget = Config::get('app.loggers.monolog.target');

        $channel = APP_ENV . '-logger';
        $logger = new MonologLogger($channel);

        switch($monologTarget) {
            case 'syslog':
                $syslogHandler = new SyslogHandler($channel, 'local6');
                $syslogHandler->setFormatter(new JsonFormatter());
                $logger->pushHandler($syslogHandler);
                break;
            default:
                throw new \Exception('Invalid monolog type');
        }

        return $logger;
    }
}
