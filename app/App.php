<?php

namespace Book\Shop;

use Book\Shop\Helpers\Request;

class App
{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        
        if (file_exists("app/controllers/{$url[0]}.php")) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        $namespace = "Book\\Shop\\Controllers\\$this->controller";
        $this->controller = new $namespace;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        $request = new Request();
        $this->params = [$request];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl(): array
    {
        $router = (new Routes())->initRoutes();
        $route = $router->checkRoute();
        if (empty($route)) {
            die('404');
        }
        return explode("@", $route['fn']);
    }
}
