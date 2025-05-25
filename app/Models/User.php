<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'store_name', 'phone', 'address', 'debt'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // App\Models\User.php
    public function getDebtAttribute()
    {
        return $this->orders()
            ->whereIn('payment_status', ['pending', 'credit'])
            ->get()
            ->sum('remaining_debt');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
