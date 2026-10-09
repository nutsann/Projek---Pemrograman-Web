<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = ['event_id', 'user_id', 'name', 'phone', 'notes', 'status'];

    public function event()
    {
        return $this->belongsTo(EventModel::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
