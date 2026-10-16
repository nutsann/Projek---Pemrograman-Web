<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['umkm_id', 'category_id', 'name', 'slug', 'description', 'price', 'stock', 'image', 'is_featured', 'status'];

    protected $casts = ['price' => 'decimal:2'];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function avgRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function reviewCount()
    {
        return $this->reviews()->count();
    }
}
