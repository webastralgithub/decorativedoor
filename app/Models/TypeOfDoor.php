<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfDoor extends Model
{
    use HasFactory;

    protected $table  = "type_of_door";

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
