<?php

namespace App\Components;

class Logger
{
    const ERROR_LOG_LEVEL   = 'ERROR';
    const WARNING_LOG_LEVEL = 'WARNING';
    const DEBUG_LOG_LEVEL   = 'DEBUG';

    public static function log($importance, $message)
    {
        $currentDateTimeString = (new \DateTime())->format('Y-m-d H:i:s');
        $logLine               = $currentDateTimeString . ' - ' . strtoupper($importance) . ' - ' . $message . PHP_EOL;

        $logFilePath = Config::get('logFile');

        $logResult = file_put_contents($logFilePath, $logLine, FILE_APPEND);

        if($logResult === false) {
            throw new \Exception();
        }
    }
}
