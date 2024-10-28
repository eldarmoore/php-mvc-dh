<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

spl_autoload_register(function (string $class_name) {
    require "src/" . str_replace("\\", "/", $class_name) . ".php";
});

$router = new \Framework\Router();

// Add routes to the routing table
$router->add("/{controller}/{action}");
$router->add("/{controller}/{id}/{action}");
$router->add("/home/index", ["controller" => "home", "action" => "index"]);
$router->add("/products", ["controller" => "products", "action" => "index"]);
$router->add("/", ["controller" => "home", "action" => "index"]);

// Match the current path to a route
$params = $router->match($path);

print_r($params);

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
$controller_object->$action();