<?php

namespace Bespoke\Components;

use Bespoke\Tools\Config;
use Bespoke\Exceptions\InvalidServiceDefinitionException;

class Container
{
    private static $instance;

    private $services = [];

    private $aliases = [];

    private $singletons = [];

    protected function __construct() { }
    protected function __clone() { }
    private function __wakeup() { }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $container = new static;

            $container->loadFrameworkServices();
            $container->loadApplicationServices();

            self::$instance = $container;
        }

        return self::$instance;
    }

    protected function loadFrameworkServices()
    {
        $services = require FRAMEWORK_PATH.'/Configuration/services.php';

        $this->loadServices($services['mappings']);
        $this->loadAliases($services['aliases']);
    }

    protected function loadApplicationServices()
    {
        $services = Config::get('app.services');

        $this->loadServices($services['mappings']);
        $this->loadAliases($services['aliases']);
    }

    protected function loadServices(array $serviceMappings)
    {
        foreach($serviceMappings as $serviceName => $serviceProvider) {
            if (class_exists($serviceProvider)) {
                if (!array_key_exists($serviceName, $this->services) || $serviceProvider::canBeReplaced()) {
                    $this->services[$serviceName] = $serviceProvider;
                }
            }
        }
    }

    protected function loadAliases(array $aliases)
    {
        foreach($aliases as $aliasName => $serviceName) {
            if(!isset($this->services[$serviceName])) {
                throw new \Exception('An alias was provided to undefined service '.$serviceName);
            }

            $this->aliases[$aliasName] = $serviceName;
        }
    }

    public function registerService($serviceName, $serviceProviderClass)
    {
        $this->services[$serviceName] = $serviceProviderClass;
    }

    public function get($serviceNameOrAlias)
    {
        $isServiceName = array_key_exists($serviceNameOrAlias, $this->services);
        $isAlias       = array_key_exists($serviceNameOrAlias, $this->aliases);
        if (!$isServiceName && !$isAlias) {
            return null;
        }

        $serviceName = $isAlias ? $this->aliases[$serviceNameOrAlias] : $serviceNameOrAlias;

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
