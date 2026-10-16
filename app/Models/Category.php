<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'type'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
