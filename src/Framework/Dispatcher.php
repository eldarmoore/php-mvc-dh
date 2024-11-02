<?php

namespace Framework;

use ReflectionMethod;
use ReflectionClass;

class Dispatcher
{
    public function __construct(private Router $router)
    {
    }

    public function handle(string $path)
    {
        // Match the current path to a route
        $params = $this->router->match($path);

        // If no route matches, display a 404 message
        if ($params === false) {
            exit("404 Not Found");
        }

        // Get the controller and action from the matched route
        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);

        $reflector = new ReflectionClass($controller);

        $constructor = $reflector->getConstructor();

        $dependencies = [];

        if ($constructor !== null) {

            foreach ($constructor->getParameters() as $parameter) {

                $type = (string) $parameter->getType();

                $dependencies[] = new $type;
            }
        }

        // Require and instantiate the controller
        $controller_object = new $controller(...$dependencies); // Autowiring

        $args = $this->getActionArguments($controller, $action, $params);

        // Call the action method on the controller object
        $controller_object->$action(...$args);
    }

    private function getActionArguments(string $controller, string $action, array $params): array
    {
        $args = [];

        $methods = new ReflectionMethod($controller, $action);

        foreach ($methods->getParameters() as $parameter) {

            $name = $parameter->getName();

            $args[$name] = $params[$name];
        }

        return $args;
    }

    public function getControllerName(array $params): string
    {
        $controller = $params["controller"];

        $controller = str_replace("-", "", ucwords(strtolower($controller), "-"));

        $namespace = "App\Controllers";

        if (array_key_exists("namespace", $params)) {

            $namespace .= "\\" . $params["namespace"];

        }

        return $namespace . "\\" . $controller;
    }

    private function getActionName(array $params): string
    {
        $action = $params["action"];

        $action = lcfirst(str_replace("-", "", ucwords(strtolower($action), "-")));

        return $action;
    }
}