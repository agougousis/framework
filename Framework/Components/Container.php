<?php

namespace Bespoke\Components;

use App\Components\Config;

class Container
{
    private static $instance;

    private $services = [];

    private $singletons = [];

    protected function __construct() { }
    protected function __clone() { }
    private function __wakeup() { }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $container = new static;

            $container->loadServices();

            self::$instance = $container;
        }

        return self::$instance;
    }

    protected function loadServices()
    {
        $serviceMappings = Config::get('services');

        foreach($serviceMappings as $serviceName => $serviceProvider) {
            if (class_exists($serviceProvider)) {
                $this->services[$serviceName] = $serviceProvider;
            }
        }
    }

    public function registerService($serviceName, $serviceProviderClass)
    {
        $this->services[$serviceName] = $serviceProviderClass;
    }

    public function registerObject($serviceName, $object)
    {
        if (isset($this->singletons[$serviceName])) {
            throw new \Exception('You cannot register a singleton twice.');
        }

        $this->singletons[$serviceName] = $object;
    }

    public function get($serviceName)
    {
        if (isset($this->singletons[$serviceName])) {
             return $this->singletons[$serviceName];
        }

        if (key_exists($serviceName, $this->services)) {
            $serviceProviderClass = $this->services[$serviceName];

            try {
                $service = $serviceProviderClass::build($this);
            } catch (\Exception $ex) {
                die($ex->getMessage());
            }

            return $service;
        }

        return null;
    }
}
