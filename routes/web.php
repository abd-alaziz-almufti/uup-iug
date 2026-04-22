<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', \App\Livewire\StudentDashboard::class)
    ->name('dashboard')
    ->middleware('auth');
