<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'image',
        'address',
        'email',
        'user_id'
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'customer_id');
    }
}
