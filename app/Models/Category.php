<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['name', 'slug', 'parent_id'];

    public function subcategory()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function jambs()
    {
        return $this->hasMany(Jamb::class);
    }
    public function lefts()
    {
        return $this->hasMany(Left::class);
    }
    public function rights()
    {
        return $this->hasMany(Right::class);
    }
    public function type_of_doors()
    {
        return $this->hasMany(TypeOfDoor::class);
    }
    public function location_of_doors()
    {
        return $this->hasMany(LocationOfDoor::class);
    }

}
