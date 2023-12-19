<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'value']; // Add 'stock' to fillable array

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
