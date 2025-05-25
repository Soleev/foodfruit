<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountTierHistory extends Model
{
    protected $table = 'discount_tier_history'; // Укажите правильное имя таблицы
    protected $dates = ['action_at'];
    protected $fillable = ['discount_tier_id', 'threshold_amount', 'discount_percentage', 'action', 'action_at'];
}
