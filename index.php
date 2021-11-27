<?php

require "vendor/autoload.php";
require 'bootstrap.php';

use App\Http\Request;
use App\Components\Dispatcher;

$request = Request::getInstance();

$dispatcher = new Dispatcher();
$dispatcher->dispatch($request);


