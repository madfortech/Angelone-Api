<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AngelController;
use Illuminate\Http\Request;

Route::get('/callback', [AngelController::class, 'callback']);

Route::get('/', function () {
    return view('index');
});

Route::get('/angel/login', [AngelController::class, 'redirectToAngel'])
    ->name('angel.login');

Route::get('/angel/profile', [AngelController::class, 'profile']);
Route::post('/angel/logout', [AngelController::class, 'logout']);
