<?php

use Bespoke\Routing\RouteManager;

RouteManager::addRoute('GET', '/json', 'DummyHandler@json');
RouteManager::addRoute('GET', '/xml', 'DummyHandler@xml');
RouteManager::addRoute('GET', '/request', 'DummyHandler@request');
RouteManager::addRoute('POST', '/users', 'DummyHandler@addUser');
