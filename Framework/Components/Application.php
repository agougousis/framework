<?php

namespace Bespoke\Components;

use App\Components\Container;
use Bespoke\Http\Request;

class Application extends Container
{
    public function run()
    {
        $request = Request::getInstance();
        $this->registerObject(Request::class, $request);

        $dispatcher = new Dispatcher($this);
        $dispatcher->dispatch($request);
    }
}
