<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\NotifController;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/', [AuthController::class, 'login'])->name('login.post');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::get('/dashboard', [NotifController::class, 'notif'])->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/firebase/data', [FirebaseController::class, 'getData']);
