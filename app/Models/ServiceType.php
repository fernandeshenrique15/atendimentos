<?php

namespace App\Models;

class ServiceType extends BaseModel
{
    protected $fillable = [
        'user_id',
        'description',
        'default_price',
        'default_duration',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}