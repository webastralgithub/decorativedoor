<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'user_id',
        'order_id',
        'order_date',
        'order_status',
        'total_products',
        'sub_total',
        'vat',
        'total',
        'invoice_no',
        'payment_type',
        'payment_status',
        'sales_person',
        'pay',
        'due',
    ];

    protected $casts = [
        'order_date'    => 'date',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_id = str_pad(static::max('id') + 1, 5, '0', STR_PAD_LEFT);
        });
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function deliverorder()
    {
        return $this->hasMany(DeliverQuantity::class);
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('invoice_no', 'like', "%{$value}%")
            ->orWhere('order_status', 'like', "%{$value}%")
            ->orWhere('payment_type', 'like', "%{$value}%");
    }

    public function assemble()
    {
        return $this->belongsTo(User::class,'assembler_user_id');
    }
    public function delivery()
    {
        return $this->belongsTo(User::class,'delivery_user_id');
    }
    public function accountant()
    {
        return $this->belongsTo(User::class,'accountant_user_id');
    }

    public function notes()
    {
        return $this->belongsTo(Note::class,'order_id');
    }
    public function coordinator()
    {
        return $this->belongsTo(User::class,'coordinator_user_id');
    }
    
}
