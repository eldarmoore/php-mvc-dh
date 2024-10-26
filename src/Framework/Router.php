<?php

namespace Framework;

class Router
{
    private array $routes = [];

    // Add a route to the routing table
    public function add(string $path, array $params = []): void
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
            $pattern = "#^/(?<controller>[a-z]+)/(?<action>[a-z]+)$#";

            echo $pattern, "\n", $route["path"], "\n", $route["params"];

            if (preg_match($pattern, $path, $matches)) {
                print_r($matches['action']);
                $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
                return $matches;
            }
        }

        return false;
    }
}