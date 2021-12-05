<?php

namespace Bespoke\Components;

use Bespoke\Routing\RouteManager;

class Application extends Container
{
    public function run()
    {
        RouteManager::loadRouteFiles();

        $request = $this->get('request');

        $dispatcher = new Dispatcher($this);
        $dispatcher->dispatch($request);
    }
}
