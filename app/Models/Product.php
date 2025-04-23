<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Добавляем трейт


class Product extends Model
{
    use HasFactory; // Используем трейт
    protected $fillable = ['name', 'description', 'price', 'category', 'image'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot('quantity')
            ->withTimestamps();
    }
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }
}
