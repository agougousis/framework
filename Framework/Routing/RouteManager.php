<?php

namespace Bespoke\Routing;

use Bespoke\Tools\Config;
use DirectoryIterator;

class RouteManager
{
    private static $get = [];

    private static $post = [];

    private static $put = [];

    private static $patch = [];

    private static $delete = [];

    private static $validMethods = ['get', 'post'];

    /**
     * Load all routes from route files
     */
    public static function loadRouteFiles()
    {
        $routesDirectory = Config::get('paths.routesDirectory');

        $dirIterator = new DirectoryIterator($routesDirectory);

        foreach ($dirIterator as $fileinfo) {
            if ($fileinfo->getExtension() == 'php') {
                require $routesDirectory.'/'.$fileinfo->getFilename();
            }
        }
    }

    /**
     * Returns the list of defined routes for a specific HTTP method
     *
     * @param string $method
     *
     * @return array mixed
     *
     * @throws \Exception
     */
    public static function getRoutesByMethod(string $method) : array
    {
        $methodInSmall = strtolower($method);

        if (!in_array($methodInSmall, self::$validMethods)) {
            throw new \Exception('Unsupported HTTP method!');
        }

        return self::$$methodInSmall;
    }

    /**
     * Adds a single route to the routes lists
     *
     * @param string $method  An HTTP method supported by this API
     * @param string $path    The expected URL path
     * @param string $handler Must be in the form: '<className>@<methodName>'
     *
     * @throws \Exception
     */
    public static function addRoute(string $method, string $path, string $handler)
    {
        $lowercaseMethod = strtolower($method);

        if (!in_array($lowercaseMethod, self::$validMethods)) {
            throw new \Exception("Unknown HTTP method '$method'.");
        }

        self::$$lowercaseMethod[$path] = $handler;
    }

    /**
     * Returns all defined routes grouped by the HTTP method
     *
     * @return array
     */
    public static function dumpAll() : array
    {
        $routes = [];

        foreach(self::$validMethods as $method) {
            $routeListPropertyName = $method;

            $routes[$method] = self::$$routeListPropertyName;
        }

        return $routes;
    }

    /**
     * Returns all the supported HTTP methods
     *
     * @return array
     */
    public static function getValidMethods() : array
    {
        return self::$validMethods;
    }
}
