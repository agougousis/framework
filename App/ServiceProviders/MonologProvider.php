<?php

namespace App\ServiceProviders;

use Bespoke\Components\Container;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\SyslogHandler;
use Monolog\Handler\RotatingFileHandler;
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
        $monologConfig = Config::get('app.loggers.monolog');

        $channel = APP_ENV . '-logger';
        $logger = new MonologLogger($channel);

        switch($monologConfig['target']) {
            case 'syslog':
                $syslogHandler = new SyslogHandler($channel, 'local6');
                $syslogHandler->setFormatter(new JsonFormatter());
                $logger->pushHandler($syslogHandler);
                break;
            case 'file':
                $logPath = $monologConfig['directory'] . '/' .$channel . '.log';
                $fileHandler = new RotatingFileHandler($logPath, 7);
                $fileHandler->setFormatter(new JsonFormatter());
                $logger->pushHandler($fileHandler);
                break;
            default:
                throw new \Exception('Invalid monolog type');
        }

        return $logger;
    }
}
