<?php

namespace App\ServiceProviders;

use App\Components\Config;
use App\Contracts\MessageQueue;
use App\Queues\FileQueue;
use App\Queues\WebQueue;

class MessageQueueServiceProvider
{
    public static function build() : MessageQueue
    {
        $queueType = Config::get('message_queue_type');

        switch($queueType) {
            case 'file':
                $queueDirectory = Config::get('file_queue_directory');

                $messageQueue = new FileQueue($queueDirectory);

                break;
            case 'web':
                $host = Config::get('async_queue_process_host');

                $messageQueue = new WebQueue($host);

                break;
            default:
                throw new \Exception('Unknown message queue type!');
        }

        return $messageQueue;
    }
}
