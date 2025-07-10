<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect()->route('users.index');
});

// Rutas de autenticación
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de usuarios
Route::get('users/{user}/profile', [UserController::class, 'profile'])->name('users.profile');
Route::resource('users', UserController::class);

// Rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    Route::post('users/{user}/add-friend', [UserController::class, 'addFriend'])->name('users.addFriend');
    Route::post('users/{user}/remove-friend', [UserController::class, 'removeFriend'])->name('users.removeFriend');
});
