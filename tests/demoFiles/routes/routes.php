<?php

use App\Routing\RouteManager;

RouteManager::addRoute('GET', '/messages', 'SmsMessageHandler@list');
RouteManager::addRoute('GET', '/messages/2', 'SmsMessageHandler@get');
RouteManager::addRoute('POST', '/messages', 'SmsMessageHandler@send');
