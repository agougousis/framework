<?php

define('BESPOKE_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../bootstrap.php';

use Bespoke\Components\Application;
use Bespoke\Components\ExceptionManager;

$application = Application::getInstance();
ExceptionManager::initialize($application);
$application->run();


