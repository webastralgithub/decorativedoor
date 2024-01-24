<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'order_id',
        'product_id',
        'order_status',
        'quantity',
        'unitcost',
        'total',
        'discount',
        "door_type",
                "door_jamb",
                "door_location",
                "door_left",
                "door_right",
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $with = ['product'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
