<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    protected $table = 'events';

    protected $fillable = ['name', 'slug', 'description', 'image', 'start_date', 'end_date', 'location', 'latitude', 'longitude', 'is_registration_open', 'max_participants', 'status'];

    protected $casts = ['start_date' => 'datetime', 'end_date' => 'datetime', 'is_registration_open' => 'boolean'];

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }
}
