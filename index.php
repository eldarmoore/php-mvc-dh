<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//require "src/router.php";

$router = new Router();

// Add routes to the routing table
$router->add("/home/index", ["controller" => "home", "action" => "index"]);
$router->add("/products", ["controller" => "products", "action" => "index"]);
$router->add("/", ["controller" => "home", "action" => "index"]);

// Match the current path to a route
$params = $router->match($path);

// If no route matches, display a 404 message
if ($params === false) {
    exit("404 Not Found");
}

// Get the controller and action from the matched route
$controller = $params["controller"];
$action = $params["action"];

// Require and instantiate the controller
require "src/controllers/$controller.php";
$controller_object = new $controller();

// Call the action method on the controller object
$controller_object->$action();