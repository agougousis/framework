<?php

namespace App\Http;

class JsonResponse
{
    private $statusCode;

    private $responseData;

    public function __construct($statusCode, $responseData)
    {
        $this->statusCode = $statusCode;
        $this->responseData = $responseData;
    }

    public function send()
    {
        http_response_code($this->statusCode);

        header('Content-type:application/json;charset=utf-8');

        echo json_encode($this->responseData);
    }
}
