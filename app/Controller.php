<?php

namespace Book\Shop;

class Controller
{
    public function view($view, $data = []): string
    {
        return View::load(
            $view . ".twig",
            VIEW_PATH,
            $data
        );
    }
}
