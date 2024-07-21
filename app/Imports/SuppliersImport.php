<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Supplier;

class SuppliersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Validate required fields
            if (!isset($row['first_name']) || !isset($row['last_name']) || !isset($row['address'])) {
                // Skip this row or handle the error as needed
                continue;
            }

            $imageNames = [];
            if (isset($row['image'])) {
                $imageNames = explode(',', $row['image']); // Assuming images are separated by commas
            }

            // Create Supplier
            $supplier = Supplier::create([
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'address' => $row['address'],
                'image' => implode(',', $imageNames),
            ]);
        }
    }
}
