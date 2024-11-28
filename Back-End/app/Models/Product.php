<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'productName',
        'productName_AR',
        'discreption',
        'discreption_AR',
        'price',
        'quantity',
        'Product_image',
        'tags',
    ];



    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
