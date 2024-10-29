<?php

namespace Framework;

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
        $action = $params["action"];
        $controller = "App\Controllers\\" . ucwords($params["controller"]);

        // Require and instantiate the controller
        $controller_object = new $controller();

        // Call the action method on the controller object
        $controller_object->$action($params["id"]);
    }
}