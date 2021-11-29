<?php

use Bespoke\Routing\RouteManager;

RouteManager::addRoute('GET', '/json', 'DummyHandler@json');
RouteManager::addRoute('GET', '/xml', 'DummyHandler@xml');
RouteManager::addRoute('POST', '/users', 'DummyHandler@addUser');
