<?php

namespace App\Components;

class Container
{
    private static $instance;

    private $services = [];

    protected function __construct() { }
    protected function __clone() { }
    private function __wakeup() { }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $container = new self;

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

    public function register($serviceName, $serviceProviderClass)
    {
        $this->services[$serviceName] = $serviceProviderClass;
    }

    public function get($serviceName)
    {
        if (key_exists($serviceName, $this->services)) {
            $serviceProviderClass = $this->services[$serviceName];

            try {
                $service = call_user_func([$serviceProviderClass, 'build']);
            } catch (\Exception $ex) {
                die($ex->getMessage());
            }

            return $service;
        }
    }
}
