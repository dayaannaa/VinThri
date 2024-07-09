<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSupply extends Model
{
    protected $primaryKey = 'product_supplier_id';

    protected $fillable = [
        'date_supplied',
        'price',
        'supplier_id',
        'product_id'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
