<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spec extends Model
{
    use HasFactory;
    //
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
