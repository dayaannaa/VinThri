<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Product;
use App\Models\ProductSupply;
use App\Models\Inventory;

class ProductsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $product = Product::create([
                'name' => $row['name'],
                'price' => $row['price'],
                'description' => $row['description'] ?? '',
                'category_id' => $row['category_id'],
                'images' => isset($row['images']) ? implode(',', explode(',', $row['images'])) : '',
            ]);

            ProductSupply::create([
                'product_id' => $product->product_id,
                'supplier_id' => $row['supplier_id'],
                'price' => $row['supplier_price'],
                'date_supplied' => $row['date_supplied'],
            ]);

            Inventory::create([
                'product_id' => $product->product_id,
                'stock' => $row['stock'],
            ]);
        }
    }
}
