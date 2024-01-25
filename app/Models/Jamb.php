<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jamb extends Model
{
    use HasFactory;

    protected $table  = "jambs";
    protected $guarded = [];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
