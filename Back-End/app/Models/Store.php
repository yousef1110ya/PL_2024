<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'StoreName',
        'StoreName_AR',
        'location',
        'complainNumber',
        'tags',
    ];

    protected $casts = ['tags' => 'array',];


    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
