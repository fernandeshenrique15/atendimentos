<?php

use App\Livewire\Calendar;
use Illuminate\Support\Facades\Route;

Route::get('/user/calendar', Calendar::class)->middleware('auth');
