<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'sale_id', 'product_id', 'price', 'quantity', 'total_amount',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
