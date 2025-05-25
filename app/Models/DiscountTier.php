<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountTier extends Model
{
    protected $fillable = ['threshold_amount', 'discount_percentage'];

    public function history()
    {
        return $this->hasMany(DiscountTierHistory::class);
    }
}
