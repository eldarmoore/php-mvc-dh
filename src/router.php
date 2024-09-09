<?php

class Router
{
    private array $routes = [];

    // Add a route to the routing table
    public function add(string $path, array $params): void
    {
        $this->routes[] = [
            "path" => $path,
            "params" => $params
        ];
    }

    // Match the requested URL path to the routing table
    public function match(string $path): array|bool
    {
        foreach ($this->routes as $route) {
            if ($route["path"] === $path) {
                return $route["params"];
            }
        }
        return false;
    }
}