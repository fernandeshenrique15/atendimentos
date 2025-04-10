<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'cpf',
        'whatsapp',
        'email',
        'password',
        'commercial_address_street',
        'commercial_address_number',
        'commercial_address_neighborhood',
        'commercial_address_city',
        'commercial_address_zipcode',
        'is_admin',
        'first_login'
    ];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function serviceTypes()
    {
        return $this->hasMany(ServiceType::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function expenseTypes()
    {
        return $this->hasMany(ExpenseType::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Verifica se o painel é 'admin' ou 'user'
     */
    public function canAccessPanel(Panel $panel): bool
    {

        if ($panel->getId() === 'admin')
            return $this->is_admin === true;


        if ($panel->getId() === 'user')
            return $this->is_admin === false;


        return false;
    }

    public function needsPasswordChange(): bool
    {
        return $this->first_login;
    }
}
