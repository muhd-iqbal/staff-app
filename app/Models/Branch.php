<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function order_item()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
    public function staff()
    {
        return $this->hasMany(User::class);
    }
    public function cashflow()
    {
        return $this->hasMany(Cashflow::class);
    }
}
