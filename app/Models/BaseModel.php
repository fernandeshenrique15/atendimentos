<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    public $timestamps = false;
    protected $keyType = 'string';
}