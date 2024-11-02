<?php

namespace Framework;

use ReflectionClass;

class Container
{
    public function get(string $class_name)
    {
        $reflector = new ReflectionClass($class_name);

        $constructor = $reflector->getConstructor();

        $dependencies = [];

        if ($constructor === null) {

            return new $class_name;
        }

        foreach ($constructor->getParameters() as $parameter) {

            $type = (string) $parameter->getType();

            $dependencies[] = $this->get($type);
        }

        // Require and instantiate the controller
        return new $class_name(...$dependencies); // Autowiring
    }
}