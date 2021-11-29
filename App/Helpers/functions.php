<?php

use Bespoke\Exceptions\FrameworkException;
use App\Exceptions\CustomException as CustomException;
use App\Components\Logger;
use App\Components\Container;

function container() {
    return Container::getInstance();
}

function customExceptionHandler(Throwable $exception)
{
    if ($exception instanceof CustomException) {
        $statusCode = $exception->getStatusCode();
        $message = $exception->getMessage();
    } else if($exception instanceof FrameworkException) {
        $statusCode = 500;
        $message = $exception->getMessage();
    } else {
        $statusCode = 500;
        $message = 'Something wrong happened! Please, try again later.';

        Logger::log(Logger::ERROR_LOG_LEVEL, $exception->getMessage());
    }

    http_response_code($statusCode);
    header('Content-type:application/json;charset=utf-8');

    $responseData = [
        'statusCode' => $statusCode,
        'message'    => $message
    ];

    echo json_encode($responseData);
}
