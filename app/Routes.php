<?php

namespace Book\Shop;

use Book\Shop\Helpers\Router;

class Routes
{
    public function initRoutes(): Router
    {
        $router = new Router();
        $router->get('/', 'HomerController@index');

        return $router;
    }
}
