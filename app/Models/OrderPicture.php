<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPicture extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order_item()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
