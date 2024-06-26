<?php

namespace Book\Shop\Helpers;

class Router
{
    protected array $routes = [];
    protected ?string $basePath = null;

    private function register($method, $pattern, $function): void
    {
        $this->routes[$method][] = [
            'pattern' => $pattern,
            'fn' => $function,
        ];
    }

    /**
     * Registers a route for the GET HTTP method.
     * 
     */
    public function get($pattern, $function): void
    {
        $this->register('GET', $pattern, $function);
    }

    /**
     * Registers a route for the POST HTTP method.
     * 
     */
    public function post($pattern, $function): void
    {
        $this->register('POST', $pattern, $function);
    }

    /**
     * Retrieves all registered routes.
     
     */
    public function all(): array
    {
        return $this->routes;
    }

    public function checkRoute(): array
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = substr(rawurldecode($_SERVER['REQUEST_URI']), strlen($this->getBasePath()));
        
        // split params
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
