<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../bootstrap.php';

use App\Http\Request;
use App\Components\Dispatcher;

$request = Request::getInstance();

$dispatcher = new Dispatcher();
$dispatcher->dispatch($request);


