<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_number', 'user_id', 'subtotal', 'shipping_cost', 'total', 'shipping_name', 'shipping_phone', 'shipping_address', 'status', 'notes'];

    protected $casts = ['subtotal' => 'decimal:2', 'total' => 'decimal:2'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public static function statusLabel($s)
    {
        return ['pending' => 'Menunggu Konfirmasi', 'processing' => 'Diproses', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'][$s] ?? $s;
    }
}
