<?php

namespace Bespoke\Services;

use Psr\Log\LoggerInterface;

class FileLogger implements LoggerInterface
{
    private $logFileDirectory;

    public function __construct($logFileDirectory)
    {
        $this->logFileDirectory = $logFileDirectory;
    }

    public function debug($message, array $context = [])
    {
        $this->log('debug', $message, $context);
    }

    public function info($message, array $context = [])
    {
        $this->log('info', $message, $context);
    }

    public function notice($message, array $context = [])
    {
        $this->log('notice', $message, $context);
    }

    public function warning($message, array $context = [])
    {
        $this->log('warning', $message, $context);
    }

    public function error($message, array $context = [])
    {
        $this->log('error', $message, $context);
    }

    public function critical($message, array $context = [])
    {
        $this->log('critical', $message, $context);
    }

    public function alert($message, array $context = [])
    {
        $this->log('alert', $message, $context);
    }

    public function emergency($message, array $context = [])
    {
        $this->log('emergency', $message, $context);
    }

    public function log($level, $message, $logContext = [])
    {
        $now = new \DateTime();
        $date = $now->format('Y-m-d');
        $filename = 'log-'.$date.'.log';
        $filePath = $this->logFileDirectory . '/' . $filename;

        $currentDateTimeString = (new \DateTime())->format('Y-m-d H:i:s');
        $jsonContext = json_encode($logContext);
        $logLine = $currentDateTimeString . ' - ' . strtoupper($level) . ' - ' . $message . $jsonContext . PHP_EOL;

        file_put_contents($filePath, $logLine, FILE_APPEND);
    }
}
