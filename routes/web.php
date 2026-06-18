<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;

Route::get('/',[AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',[AuthController::class, 'login'])->name('login.submit');
