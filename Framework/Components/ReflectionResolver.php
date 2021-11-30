<?php

namespace Bespoke\Components;

use App\Components\Container;

class ReflectionResolver
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $class
     * @return object
     * @throws \ReflectionException
     */
    public function resolveClass(string $class): object
    {
        if (($serviceInstance = $this->container->get($class)) !== null) {
            return $serviceInstance;
        }

        $reflectionClass = new \ReflectionClass($class);

        if (($constructor = $reflectionClass->getConstructor()) === null) {
            return $reflectionClass->newInstance();
        }

        $resolvedParameters = $this->resolveReflectionMethodParameters($constructor);

        if ($resolvedParameters === []) {
            return $reflectionClass->newInstance();
        }

        return $reflectionClass->newInstanceArgs($resolvedParameters);
    }

    public function resolveMethodParameters(object $object, string $methodName): array
    {
        $reflectionClass = new \ReflectionClass($object);

        if (($method = $reflectionClass->getMethod($methodName)) === null) {
            throw new \Exception('Method to be resolved was not found.');
        }

        $resolvedParameters = $this->resolveReflectionMethodParameters($method);

        return $resolvedParameters;
    }

    private function resolveReflectionMethodParameters(\ReflectionMethod $method): array
    {
        $params = $method->getParameters();

        if ($params === []) {
            return $params;
        }

        $newInstanceParams = [];
        foreach ($params as $param) {
            $newInstanceParams[] = $param->getClass() === null ? $param->getDefaultValue() : $this->resolveClass(
                $param->getClass()->getName()
            );
        }

        return $newInstanceParams;
    }
}
