<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Culture extends Model
{
    protected $fillable = ['category_id', 'name', 'slug', 'short_description', 'description', 'history', 'location', 'latitude', 'longitude', 'image', 'gallery', 'is_featured'];

    protected $casts = ['gallery' => 'array'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
