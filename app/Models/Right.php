<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Right extends Model
{
    use HasFactory;

    protected $table  = "right";

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
