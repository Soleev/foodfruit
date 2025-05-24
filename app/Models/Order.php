<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'delivery_status',
        'payment_status',
    ];

    protected $attributes = [
        'delivery_status' => 'new', // Начальный статус доставки
        'payment_status' => 'pending', // Начальный статус оплаты
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
