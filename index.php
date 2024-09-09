<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

require "src/router.php";

$router = new Router();

// Add routes to the routing table
$router->add("/home/index", ["controller" => "home", "action" => "index"]);
$router->add("/products", ["controller" => "products", "action" => "index"]);
$router->add("/", ["controller" => "home", "action" => "index"]);

// Match the current path to a route
$params = $router->match($path);

// For testing, print the matched parameters and exit
var_dump($params);
exit;

// If matched, proceed with extracting controller and action
$segments = explode('/', $path);

// Get the controller and action from the URL
$action = $segments[2];
$controller = $segments[1];

// Require and instantiate the controller
require "src/controllers/$controller.php";
$controller_object = new $controller();

// Call the action method
$controller_object->$action();