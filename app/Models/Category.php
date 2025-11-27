<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    //
    protected $guarded = [];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function specs()
    {
        return $this->hasMany(Spec::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
