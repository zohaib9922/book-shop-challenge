<?php

namespace Book\Shop\Controllers;

use Book\Shop\Controller;
use Book\Shop\Helpers\Request;
use Book\Shop\Helpers\VersionCompare;
use Book\Shop\Models\Sale;

class HomeController extends Controller
{
    /**
     * Fetch data and with filter and show 
     */
    public function index(Request $request): void
    {
        $conditons = [];
        if (!empty($request->get('customer'))) {
            $conditons[] = " customers.name like ('%" . $this->trimValue($request->get('customer')) . "%') ";
        }

        if (!empty($request->get('product'))) {
            $conditons[] = (count($conditons) > 0 ? "AND" : "") .
                " products.name like ('%" . $this->trimValue($request->get('product')) . "%') ";
        }

        if (!empty($request->get('price'))) {
            $conditons[] = (count($conditons) > 0 ? "AND" : "") .
                " products.price like ('" . $this->trimValue($request->get('price')) . "') ";
        }

        $sales = (new Sale())
            ->as("
                products.name as productName,
                products.price as price,
                customers.name as customerName,
                customers.email as customerEmail,
                sales.sale_date as sale_date,
                sales.version as version
            ")
            ->where($conditons)
            ->withMulti([
                'customer_id' => 'Customer',
                'product_id' => 'Product',
            ])
            ->get();

        // Adding timezone based on version comparison
        foreach ($sales as $key => $row) {
            $sales[$key]['timezone'] = VersionCompare::compare($row['version']);
        }
        
        echo $this->view('home', [
            'sales' => $sales, 
            'customer' => $request->get('customer'),  
            'product' => $request->get('product'),
            'price' => $request->get('price'),
        ]);
    }

    private function trimValue(string $value): string
    {
        return trim(addslashes($value));
    }
}