<?php

namespace App\Queues;

use App\Components\Logger;
use App\Contracts\MessageQueue;
use App\Entities\MessageUnit;
use GuzzleHttp\Client;

class WebQueue implements MessageQueue
{
    /** @var string The base URL to the queue service */
    private $baseUrl;

    /** @var string The endpoint that needs to be contacted in order to push a message to the queue */
    private $pushEndpoint;

    /** @var string The endpoint that needs to be contacted in order to get the status of the queue */
    private $statusEndpoint;

    public function __construct($baseUrl)
    {
        $this->baseUrl        = $baseUrl;
        $this->pushEndpoint   = $this->baseUrl.'/push';
        $this->statusEndpoint = $this->baseUrl.'/status';
    }

    public function push(MessageUnit $messageUnit)
    {
        $serializedMessage = serialize($messageUnit);

        $client     = new Client();
        $response   = $client->request('POST', $this->pushEndpoint, ['body' => $serializedMessage]);
        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            Logger::log(Logger::ERROR_LOG_LEVEL, $response->getBody());

            throw new \Exception('Queue service is unavailable!');
        }
    }
}
