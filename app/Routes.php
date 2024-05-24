<?php

namespace Book\Shop;

use Book\Shop\Helpers\Router;

class Routes
{
    public function initRoutes(): Router
    {
        $router = new Router();
        $router->get('/', 'HomerController@index');
        $router->get('/migrate/up', 'MigrationController@up');
        $router->get('/migrate/down', 'MigrationController@down');

        return $router;
    }
}
