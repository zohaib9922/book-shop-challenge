<?php

namespace Book\Shop;

class Controller
{
    public function view($view): string
    {
        return View::load(
            $view . ".twig",
            VIEW_PATH
        );
    }
}
