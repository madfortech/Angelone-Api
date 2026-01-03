<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AngelController;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/angel/login', [AngelController::class, 'redirectToAngel'])
    ->name('angel.login');

Route::get('/angel/profile', [AngelController::class, 'profile'])->name('angel.profile');
Route::post('/angel/logout', [AngelController::class, 'logout'])->name('angel.logout');



Route::get('/callback', [AngelController::class, 'callback']);


require __DIR__.'/auth.php';
