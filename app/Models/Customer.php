<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers'; // Указываем имя таблицы, если оно отличается от стандартного

    protected $fillable = [
        'seller_name',
        'shop_name',
        'products',
        'district',
        'address',
        'location',
        'phone_number',
        'comment',
    ];
}
