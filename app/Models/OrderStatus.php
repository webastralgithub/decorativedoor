<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    const PENDING_ORDER_CONFIRMATION = '1';
    const COMPLETE = '2';
    const FAILED = '3';
    const READY_TO_PRODUCTION = '4';
    const READY_TO_DELIVER = '5';
    const DISPATCHED = '6';

    public $fillable = ['name'];
    protected $timestamp = false;

    static function getStatusNameById($statusId = 1)
    {
        $statusId = ($statusId == 0) ? 1 : $statusId;
        return convertToReadableStatus(OrderStatus::find($statusId)->name);
    }
}
