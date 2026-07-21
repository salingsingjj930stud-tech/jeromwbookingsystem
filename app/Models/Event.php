<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'capacity', 'description'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}