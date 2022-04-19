<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVoucherList extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function voucher()
    {
        return $this->belongsTo(PaymentVoucher::class);
    }
}
