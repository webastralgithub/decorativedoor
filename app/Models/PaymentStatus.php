<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    use HasFactory;

    const PENDING = '1';
    const PAID = '2';
    const FAILED = '3';
    const REFUNDED = '4';

    public $fillable = ['name'];
    protected $timestamp = false;
}
