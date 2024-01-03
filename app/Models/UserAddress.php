<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'street', 'city', 'state', 'country', 'zip_code', 'address_type'];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}