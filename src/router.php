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
}