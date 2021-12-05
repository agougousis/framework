<?php

namespace Bespoke\Components;

use App\Exceptions\CustomException as CustomException;
use Bespoke\Exceptions\FrameworkException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class ExceptionManager
{
    /** @var LoggerInterface */
    private $logger;

    private function __construct(Container $container) {
        $this->logger = $container->get('logger');
    }

    public static function initialize(Container $container)
    {
        $exceptionManager = new self($container);

        set_exception_handler([$exceptionManager, 'exceptionHanlder']);
        set_error_handler([$exceptionManager, 'errorHandler']);
    }

    /**
     * PHP 7 changes how most errors are reported by PHP. Instead of reporting errors through the traditional error
     * reporting mechanism used by PHP 5, most errors are now reported by throwing Error exceptions. However, even in PHP7,
     * some errors make it through to the errorHandler, so convert these to Exceptions and let the exception handler
     * log it and display it.
     */
    public function errorHandler(int $severity, string $message, ?string $file = null, ?int $line = null)
    {
        if (! (error_reporting() & $severity)) {
            return;
        }

        // Convert it to an exception and pass it along.
        throw new \ErrorException($message, 0, $severity, $file, $line);
    }

    public function exceptionHanlder(\Throwable $exception)
    {
        if (($exception instanceof CustomException) || ($exception instanceof FrameworkException)) {
            $statusCode = $exception->getStatusCode();
            $message = $exception->getMessage();
        } else {
            if (defined('APP_ENV') && APP_ENV !== 'production') {
                $statusCode = $exception->getCode();
                $message = $exception->getMessage();
            } else {
                $statusCode = 500;
                $message = 'Something wrong happened! Please, try again later.';
            }

            $logContext = $this->gatherExceptionData($exception);
            $this->logger->log(LogLevel::ERROR, $exception->getMessage(), $logContext);
        }

        http_response_code($statusCode);
        header('Content-type:application/json;charset=utf-8');

        $responseData = [
            'statusCode' => $statusCode,
            'message'    => $message
        ];

        echo json_encode($responseData);
    }

    private function gatherExceptionData(\Throwable $throwable): array
    {
        $data = [
            'code' => $throwable->getCode(),
            'message' => $throwable->getMessage(),
            'exceptionClass' => get_class($throwable),
            'called' => [
                'class' => $throwable->getTrace()[0]['class'],
                'function' => $throwable->getTrace()[0]['function']
            ],
            'occured' => [
                'file' => $throwable->getFile(),
                'line' => $throwable->getLine()
            ],
            'trace' => explode("\n", $throwable->getTraceAsString())
        ];

        return $data;
    }
}
