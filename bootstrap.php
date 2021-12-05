<?php

use App\Components\Config;
use Bespoke\DotEnv;

define('ROOT_PATH', __DIR__);
define('CONFIG_PATH', __DIR__.'/config');

require ROOT_PATH . '/Framework/Helpers/functions.php';

$env = new DotEnv(ROOT_PATH);
$env->load();

if (!defined('APP_ENV')) {
    define('APP_ENV', 'development');
}

Config::loadConfigurationFiles();

switch (APP_ENV) {
    case 'production':
        ini_set('display_errors', '0');
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        break;
    case 'development':
    case 'testing':
        error_reporting(-1);
        ini_set('display_errors', '1');
        break;
}

