<?php

namespace Book\Shop\Controllers;

use Book\Shop\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        echo $this->view();
    }
}