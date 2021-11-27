<?php

namespace App\ApiHandlers;

use App\Http\JsonResponse;

class SmsMessageHandler
{
    private $errorMessages;

    public function __construct()
    {
        $this->errorMessages = [];
    }

    public function send() : JsonResponse
    {
        $messageQueue = container()->get('messageQueue');

        return new JsonResponse(200, 'Message received!');
    }
}


