<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;
    //
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function spec()
    {
        return $this->hasMany(Spec::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
    
}
