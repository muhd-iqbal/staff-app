<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationPicture extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quotation_item()
    {
        return $this->belongsTo(QuotationItem::class);
    }
}
