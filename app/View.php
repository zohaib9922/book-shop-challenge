<?php

namespace Book\Shop;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    public static function load(string $name, string $path): string
    {
        $loader = new FilesystemLoader($path);
        $view = new Environment($loader, ['debug' => true]);
        return $view->render($name);
    }
}
