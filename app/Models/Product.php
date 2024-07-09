<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'name',
        'images',
        'price',
        'description',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function productsupplies()
    {
        return $this->hasMany(ProductSupply::class, 'product_id')->with('supplier');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id');
    }


}
