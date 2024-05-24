<?php

namespace Book\Shop\Controllers;

use Book\Shop\Controller;

class SaleController extends Controller
{
    public function importSales(Request $request): void
    {
        $file = $request->getFile('sales_input');

        $fileData = json_decode(file_get_contents($file), true);
    }

}
