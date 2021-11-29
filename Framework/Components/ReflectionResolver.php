<?php

namespace Bespoke\Components;

class ReflectionResolver
{
    /**
     * @param string $class
     * @return object
     * @throws \ReflectionException
     */
    public function resolve(string $class): object
    {
        $reflectionClass = new \ReflectionClass($class);

        // If the class does not defined a constructor, we can safely instantiate the class.
        if (($constructor = $reflectionClass->getConstructor()) === null) {
            return $reflectionClass->newInstance();
        }

        // If the class defines a constructor without parameters, we can safely instantiate the class.
        if (($params = $constructor->getParameters()) === []) {
            return $reflectionClass->newInstance();
        }

        // Resolve constructor parameteres. If a parameter has a scalar type, assign to it the default value.
        // If it has a class type, call the resolver for that class.
        $newInstanceParams = [];
        foreach ($params as $param) {
            $newInstanceParams[] = $param->getClass() === null ? $param->getDefaultValue() : $this->resolve(
                $param->getClass()->getName()
            );
        }

        // Call the constructor passing the resolved parameters.
        return $reflectionClass->newInstanceArgs(
            $newInstanceParams
        );
    }
}
