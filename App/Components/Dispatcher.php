<?php

namespace App\Components;

use Bespoke\Http\Request;
use Bespoke\Http\Response;
use Bespoke\Routing\Router;

class Dispatcher
{
    public function dispatch(Request $request)
    {
        [$className, $methodName] = $this->getHandlerInfo($request);

        $this->callHandler($className, $methodName);
    }

    /**
     * Finds which route mathces the request and extracts the information about the handling class
     *
     * @param Request $request
     *
     * @return array [className, methodName]
     */
    protected function getHandlerInfo(Request $request) : array
    {
        $router = new Router();

        return $router->detectRoute($request);
    }

    /**
     * Engages the route handling method
     *
     * @param string $className
     * @param string $methodName
     *
     * @return Response
     *
     * @throws \Exception
     */
    protected function callHandler(string $className, string $methodName)
    {
        $controller = $this->getHandlerInstance($className);

        if (!method_exists($controller, $methodName)) {
            throw new \Exception("Method '$methodName' does not exist in class '$className'!");
        }

        /** @var Response $response */
        $response = call_user_func([$controller, $methodName]);
        $response->send();
    }

    /**
     * @param string $className
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function getHandlerInstance(string $className)
    {
        $fullyQualifiedClassName = 'App\\ApiHandlers\\'.$className;

        if (!class_exists($fullyQualifiedClassName)) {
            throw new \Exception("Class '$fullyQualifiedClassName' does not exist!");
        }

        $controller = new $fullyQualifiedClassName;

        return $controller;
    }
}
