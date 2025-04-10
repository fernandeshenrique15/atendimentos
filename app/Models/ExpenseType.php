<?php

namespace App\Models;

class ExpenseType extends BaseModel
{
    protected $fillable = [
        'user_id',
        'description',
        'frequency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}