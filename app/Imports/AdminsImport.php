<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!isset($row['first_name']) || !isset($row['last_name']) || !isset($row['email'])) {
                continue;
            }

            $user = User::create([
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'status' => 'active',
                'password' => isset($row['password']) ? Hash::make($row['password']) : null,
                'type' => 0,
            ]);

            $admin = Admin::create([
                'user_id' => $user->user_id,
                'address' => $row['address'] ?? '',
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
            ]);

            if (isset($row['image'])) {
                $imageNames = explode(',', $row['image']);
                $admin->image = implode(',', $imageNames);
                $admin->save();
            }
        }
    }
}
