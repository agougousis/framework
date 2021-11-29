<?php

define('BESPOKE_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../bootstrap.php';

use Bespoke\Http\Request;
use Bespoke\Components\Dispatcher;

$request = Request::getInstance();

$dispatcher = new Dispatcher();
$dispatcher->dispatch($request);


