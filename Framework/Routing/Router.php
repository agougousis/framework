<?php

namespace Bespoke\Routing;

use Bespoke\Exceptions\RouteNotFoundException;
use Bespoke\Http\Request;

class Router
{
    /**
     * @param Request $request
     *
     * @return array [className, methodName]
     *
     * @throws RouteNotFoundException
     */
    public function detectRoute(Request $request) : array
    {
        $path       = $request->getPath();
        $httpMethod = $request->getMethod();

        $routeManager = new RouteManager();
        $routeList    = $routeManager::getRoutesByMethod($httpMethod);

        if (!key_exists($path, $routeList)) {
            throw new RouteNotFoundException();
        }

        return $this->extractHandlerInfo($routeList, $path);
    }

    /**
     * @param array $routeList
     * @param string $path
     *
     * @return array [className, methodName]
     */
    private function extractHandlerInfo(array $routeList, string $path)
    {
        $handlerInfoString = $routeList[$path];
        $handlerInfo       = explode('@', $handlerInfoString);

        if (count($handlerInfo) != 2) {
            throw new \Exception('Invalid route definition.');
        }

        return $handlerInfo;
    }
}
