<?php

namespace Book\Shop\Controllers;

use Book\Shop\Controller;
use Book\Shop\Helpers\Request;
use Book\Shop\Helpers\VersionCompare;
use Book\Shop\Models\Sale;

class HomeController extends Controller
{
    public function index(Request $request): void
    {
        $sales = (new Sale())
            ->as("
                products.name as productName,
                products.price as price,
                customers.name as customerName,
                customers.email as customerEmail,
                sales.sale_date as sale_date,
                sales.version as version
            ")
            ->withMulti([
                'customer_id' => 'Customer',
                'product_id' => 'Product',
            ])
            ->get();

        echo $this->view('home', [
            'sales' => $sales,
        ]);
    }
}