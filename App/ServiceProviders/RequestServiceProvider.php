<?php

namespace App\ServiceProviders;

use App\Queues\FileQueue;
use App\Queues\WebQueue;
use Bespoke\Http\Request;
use Bespoke\Components\Container;

class RequestServiceProvider
{
    public static function build(Container $container) : Request
    {

    }
}
