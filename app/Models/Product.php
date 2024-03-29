<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function image()
    {
        return $this->hasOne(ProductImage::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function orderdetails()
    {
        return $this->hasMany(OrderDetails::class);
    }
    public function variant_categories()
    {
        return $this->hasMany(VariantCategory::class);
    }
}
