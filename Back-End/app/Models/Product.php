<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'quantity', 'product_image', 'store_id', 'name_AR', 'description_AR'];
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
    public function tags()
    {
        return $this->belongsToMany(ProductTags::class);
    }
}