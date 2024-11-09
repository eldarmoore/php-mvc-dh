<?php

declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\PageNotFoundException;
use ReflectionMethod;

class Dispatcher
{
    public function __construct(private Router $router, private Container $container)
    {
    }

    public function handle(Request $request)
    {
        // Match the current path to a route
        $params = $this->router->match($path, $method);

        // If no route matches, display a 404 message
        if ($params === false) {

            throw new PageNotFoundException("No route matched for '{$path}' with method '{$method}'");

        }

        // Get the controller and action from the matched route
        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);

        $controller_object = $this->container->get($controller);

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