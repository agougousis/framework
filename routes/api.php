<?php

use App\Routing\RouteManager;

RouteManager::addRoute('POST', '/messages', 'SmsMessageHandler@send');
