<?php

namespace Framework;

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
        $pattern = "#^/home/index$#";

        if (preg_match($pattern, $path, $matches)) {
            exit("Match");
        }

        foreach ($this->routes as $route) {
            if ($route["path"] === $path) {
                return $route["params"];
            }
        }
        return false;
    }
}