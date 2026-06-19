<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubUserController;


Route::get('/',[AuthController::class, 'showLoginForm'])->name('admin.show');
Route::post('/',[AuthController::class, 'login'])->name('admin.login');
Route::get('/forgot-password', [AuthController::class,'forgot'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class,'sendReset'])->name('forgot.password.send');
Route::get('/reset-password/{token}', [AuthController::class,'reset'])->name('password.reset');
Route::post('/reset-password', [AuthController::class,'updatePassword'])->name('password.update');


Route::middleware('checkauth')->group(function(){
  Route::get('/admin/dashboard',[AdminController::class, 'dashboard'])->name('admin.dashboard');
  Route::post('/admin/logout',[AuthController::class, 'logout'])->name('admin.logout');

  Route::get('/admin/subuser/index',[SubUserController::class, 'index'])->name('subuser.index');
  Route::get('/admin/subuser/create',[SubUserController::class, 'create'])->name('subuser.create');
  Route::post('/admin/subuser/store',[SubUserController::class, 'store'])->name('subuser.store');

});