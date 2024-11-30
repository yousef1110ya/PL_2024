<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /** @use HasFactory<\Database\Factories\StoreFactory> */
    use HasFactory;

    protected $fillable = ['name', 'location'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function tags()
    {
        return $this->belongsToMany(StoreTag::class);
    }
}
