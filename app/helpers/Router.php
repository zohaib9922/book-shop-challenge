<?php

namespace Book\Shop\Helpers;

class Router
{
    protected $routes = [];
    protected $basePath = null;

    private function register($method, $pattern, $function): void
    {
        $this->routes[$method][] = [
            'pattern' => $pattern,
            'fn' => $function,
        ];
    }

    public function get($pattern, $function): void
    {
        $this->register('GET', $pattern, $function);
    }

    public function checkRoute(): array
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = substr(rawurldecode($_SERVER['REQUEST_URI']), strlen($this->getBasePath()));
        $uri = explode("?", $uri)[0];

        if (empty($uri)) {
            $uri = '/';
        }
        $routes = $this->routes[$method] ?? [];
        $found = [];

        foreach ($routes as $route) {
            if ($route['pattern'] === $uri || $route['pattern'] === "/$uri") {
                $found = $route;
                break;
            }
        }

        return $found;
    }

    public function getBasePath(): string
    {
        if ($this->basePath === null) {
            $this->basePath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        }
        return $this->basePath;
    }
}
