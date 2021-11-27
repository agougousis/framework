<?php

use App\Components\Config;
use App\Routing\RouteManager;

define('ROOT_PATH', __DIR__);
define('CONFIG_PATH', __DIR__.'/config');

require ROOT_PATH.'/App/Helpers/functions.php';

Config::loadConfigurationFiles();

RouteManager::loadRouteFiles();

set_exception_handler('customExceptionHandler');
