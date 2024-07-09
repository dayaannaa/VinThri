<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'image'
    ];

    public function productSupplies()
    {
        return $this->hasMany(ProductSupply::class, 'supplier_id');
    }
}
