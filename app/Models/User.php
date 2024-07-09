<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'status',
        'email_verified_at',
        'password',
        'type',
        'remember_token'
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'user_id');
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, 'user_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'user_id', 'customer_id');
    }
}
