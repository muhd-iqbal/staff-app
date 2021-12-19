<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_pictures()
    {
        return $this->hasMany(OrderPicture::class);
    }

    public function order_status()
    {
        return $this->hasOne(ItemStatus::class);
    }

}
