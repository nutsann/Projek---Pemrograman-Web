<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tourism extends Model
{
    protected $fillable = ['category_id', 'name', 'slug', 'short_description', 'description', 'location', 'latitude', 'longitude', 'image', 'gallery', 'open_time', 'close_time', 'ticket_price', 'is_featured'];

    protected $casts = ['gallery' => 'array', 'ticket_price' => 'decimal:2'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
