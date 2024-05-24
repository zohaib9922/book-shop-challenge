<?php

namespace Book\Shop\Controllers;

use Book\Shop\Controller;
use Book\Shop\Helpers\Request;
use Book\Shop\Models\Customer;
use Book\Shop\Models\Product;
use Book\Shop\Models\Sale;

class SaleController extends Controller
{
    /**
     * Reading json file and creating databse records
     */
    public function importSales(Request $request): void
    {
        $file = $request->getFile('sales_input');

        if (empty($file) && !file_exists($file)) {
            return;
        }

        $fileData = json_decode(file_get_contents($file), true);
        foreach ($fileData as $record) {
            $customerId = (new Customer())->insert(["name", "email"], [
                $record['customer_name'] ?? "",
                $record['customer_mail'] ?? ""
            ]);

            if (isset($record['product_id'])) {
                $product = new Product();
                $productRecord = $product->getById($record['product_id']);

                if (empty($productRecord)) {
                    $product->insert(["id", "name", "price"], [
                        $record['product_id'],
                        $record['product_name'] ?? "",
                        $record['product_price'] ?? ""
                    ]);
                }
            }

            (new Sale())->insert(
                ["id", "customer_id", "product_id", "sale_date", "version"],
                [
                    $record['sale_id'] ?? null,
                    $customerId,
                    $record['product_id'] ?? 0,
                    $record['sale_date'] ?? null,
                    $record['version'] ?? "",
                ]
            );
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

}
