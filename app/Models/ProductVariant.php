<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    // protected $fillable = ['name', 'value', 'price', 'stock']; // Add 'stock' to fillable array

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
