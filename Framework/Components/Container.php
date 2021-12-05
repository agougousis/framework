<?php

namespace Bespoke\Components;

use Bespoke\Components\Config;

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
                if (!array_key_exists($serviceName, $this->services) || $serviceProvider::canBeReplaced()) {
                    $this->services[$serviceName] = $serviceProvider;
                }
            }
        }
    }

    public function registerService($serviceName, $serviceProviderClass)
    {
        $this->services[$serviceName] = $serviceProviderClass;
    }

    public function get($serviceName)
    {
        if (!array_key_exists($serviceName, $this->services)) {
            return null;
        }

        $serviceProviderClass = $this->services[$serviceName];
        $isSingleton          = $serviceProviderClass::isSingleton();

        if ($isSingleton && isset($this->singletons[$serviceName])) {
            return $this->singletons[$serviceName];
        }

        $service = $serviceProviderClass::build($this);
        if ($isSingleton) {
            $this->singletons[$serviceName] = $service;
        }

        return $service;

    }
}
