<?php

namespace Bespoke\Components;

use Bespoke\Http\Request;
use Bespoke\Routing\RouteManager;

class Application extends Container
{
    public function run()
    {
        RouteManager::loadRouteFiles();

        $request = Request::getInstance();
        $this->registerObject(Request::class, $request);

        $dispatcher = new Dispatcher($this);
        $dispatcher->dispatch($request);
    }
}
