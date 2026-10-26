<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'name',
        'appointment_number',
        'phone_number',
        'price',
        'appointment_time',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
