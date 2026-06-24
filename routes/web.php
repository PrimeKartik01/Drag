<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubUserController;
use App\Http\Controllers\RoleController;



Route::get('/',[AuthController::class, 'showLoginForm'])->name('admin.show');
Route::post('/',[AuthController::class, 'login'])->name('admin.login');
Route::get('/forgot-password', [AuthController::class,'forgot'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class,'sendReset'])->name('forgot.password.send');
Route::get('/reset-password/{token}', [AuthController::class,'reset'])->name('password.reset');
Route::post('/reset-password', [AuthController::class,'updatePassword'])->name('password.update');


Route::middleware('checkauth')->group(function(){
  Route::get('/admin/dashboard',[AdminController::class, 'dashboard'])->name('admin.dashboard');
  Route::post('/admin/logout',[AuthController::class, 'logout'])->name('admin.logout');

  Route::get('/admin/index',[SubUserController::class, 'index'])->name('subuser.index');
  Route::get('/admin/create',[SubUserController::class, 'create'])->name('subuser.create');
  Route::post('/admin/store',[SubUserController::class, 'store'])->name('subuser.store');
  Route::get('/admin/{subuser}/edit',[SubUserController::class, 'edit'])->name('subuser.edit');
  Route::patch('/admin/{subuser}/update',[SubUserController::class, 'update'])->name('subuser.update');
  Route::delete('/admin/{subuser}/delete',[SubUserController::class, 'destroy'])->name('subuser.delete');
  Route::get('/subuser/status', [SubUserController::class, 'status'])->name('subuser.status');


  Route::get('/admin/role/index',[RoleController::class, 'index'])->name('role.index');
  Route::get('/admin/role/create',[RoleController::class, 'create'])->name('role.create');
  Route::post('/admin/role/store',[RoleController::class, 'store'])->name('role.store');
  Route::get('/admin/role/{role}/edit',[RoleController::class, 'edit'])->name('role.edit');
  Route::patch('/admin/role/{role}/update',[RoleController::class, 'update'])->name('role.update');
  Route::delete('/admin/role/{role}/delete',[RoleController::class, 'delete'])->name('role.delete');



});