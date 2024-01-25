<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationOfDoor extends Model
{
    use HasFactory;

    protected $table  = "location_of_door";

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
