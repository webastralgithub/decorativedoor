<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Left extends Model
{
    use HasFactory;
    protected $table  = "lefts";

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
