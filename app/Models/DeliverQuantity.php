<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverQuantity extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'id',
        'order_id',
        'item_id',
        'order_quantity',
        'deliver_quantity',
    ];
}
