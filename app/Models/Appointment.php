<?php

namespace App\Models;

class Appointment extends BaseModel
{
    protected $fillable = [
        'user_id',
        'client_id',
        'service_type_id',
        'date',
        'duration',
        'price',
        'is_paid',
        'is_recurring',
        'recurrence_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
}