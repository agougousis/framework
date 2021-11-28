<?php

use App\Components\Config;
use App\Routing\RouteManager;
use Bespoke\DotEnv;

define('ROOT_PATH', __DIR__);
define('CONFIG_PATH', __DIR__.'/config');

require ROOT_PATH.'/App/Helpers/functions.php';

$env = new DotEnv(ROOT_PATH);
$env->load();

Config::loadConfigurationFiles();

RouteManager::loadRouteFiles();

set_exception_handler('customExceptionHandler');
