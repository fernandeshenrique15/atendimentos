<?php

namespace App\Models;

class Client extends BaseModel
{
    protected $fillable = [
        'user_id',
        'name',
        'cpf',
        'whatsapp',
        'email',
        'address_street',
        'address_number',
        'address_neighborhood',
        'address_city',
        'address_zipcode',
        'observations',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}