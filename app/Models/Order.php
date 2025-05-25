<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'applied_discount_percentage',
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
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity')
            ->withTrashed() // ← ВАЖНО: включает удалённые продукты
            ->withTimestamps();
    }
    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
    }
    // Оставшийся долг по заказу
    public function getRemainingDebtAttribute()
    {
        $paidAmount = $this->payments->sum('amount');
        return max(0, $this->total_price - $paidAmount);
    }
    // Метод для расчета суммы без скидки
    public function getOriginalTotalPriceAttribute()
    {
        return $this->products->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });
    }
}
