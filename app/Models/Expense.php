<?php

namespace App\Models;

class Expense extends BaseModel
{
    protected $fillable = [
        'user_id',
        'expense_type_id',
        'description',
        'price',
        'date',
        'is_paid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
    }
}