<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuilderController;
use App\Http\Controllers\SubUserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TownshipController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('admin.show');
Route::post('/', [AuthController::class, 'login'])->name('admin.login');
Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'sendReset'])->name('forgot.password.send');
Route::get('/reset-password/{token}', [AuthController::class, 'reset'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');


Route::middleware('checkauth')->group(function () {
  Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
  Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

  // Subuser Route: Start
  Route::get('/admin/subuser/{subuser}/show', [SubUserController::class, 'show'])->middleware('permission:view,subusers')->name('subuser.show');
  Route::get('/admin/subuser/index', [SubUserController::class, 'index'])->middleware('permission:viewAny,subusers')->name('subuser.index');
  Route::get('/admin/subuser/create', [SubUserController::class, 'create'])->middleware('permission:create,subusers')->name('subuser.create');
  Route::post('/admin/subuser/store', [SubUserController::class, 'store'])->middleware('permission:create,subusers')->name('subuser.store');
  Route::get('/admin/subuser/{subuser}/edit', [SubUserController::class, 'edit'])->middleware('permission:update,subusers')->name('subuser.edit');
  Route::patch('/admin/subuser/{subuser}/update', [SubUserController::class, 'update'])->middleware('permission:update,subusers')->name('subuser.update');
  Route::delete('/admin/subuser/{subuser}/delete', [SubUserController::class, 'delete'])->middleware('permission:delete,subusers')->name('subuser.delete');
  Route::get('/subuser/status', [SubUserController::class, 'status'])->middleware('permission:update,subusers')->name('subuser.status');
  // Subuser Route: End

  // Role Route: Start
  Route::get('/admin/role/index', [RoleController::class, 'index'])->middleware('permission:viewAny,roles')->name('role.index');
  Route::get('/admin/role/create', [RoleController::class, 'create'])->middleware('permission:create,roles')->name('role.create');
  Route::post('/admin/role/store', [RoleController::class, 'store'])->middleware('permission:create,roles')->name('role.store');
  Route::get('/admin/role/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:update,roles')->name('role.edit');
  Route::patch('/admin/role/{role}/update', [RoleController::class, 'update'])->middleware('permission:update,roles')->name('role.update');
  Route::delete('/admin/role/{role}/delete', [RoleController::class, 'delete'])->middleware('permission:delete,roles')->name('role.delete');
  // Role Route: End

  // Builder Route: Start
  Route::get('/admin/builder/{builder}/show', [BuilderController::class, 'show'])->middleware('permission:view,builders')->name('builder.show');
  Route::get('/admin/builder/index', [BuilderController::class, 'index'])->middleware('permission:viewAny,builders')->name('builder.index');
  Route::get('/admin/builder/create', [BuilderController::class, 'create'])->middleware('permission:create,builders')->name('builder.create');
  Route::post('/admin/builder/store', [BuilderController::class, 'store'])->middleware('permission:create,builders')->name('builder.store');
  Route::get('/admin/builder/{builder}/edit', [BuilderController::class, 'edit'])->middleware('permission:update,builders')->name('builder.edit');
  Route::patch('/admin/builder/{builder}/update', [BuilderController::class, 'update'])->middleware('permission:update,builders')->name('builder.update');
  Route::delete('/admin/builder/{builder}/delete', [BuilderController::class, 'delete'])->middleware('permission:delete,builders')->name('builder.delete');
  Route::delete('/builder/bulk-delete', [BuilderController::class, 'bulkDelete'])->middleware('permission:delete,builders')->name('builder.bulkDelete');
  // Builder Route: End

  // Township Route: Start
  Route::get('/admin/township/{township}/show', [TownshipController::class, 'show'])->middleware('permission:view,townships')->name('township.show');
  Route::get('/admin/township/index', [TownshipController::class, 'index'])->middleware('permission:viewAny,townships')->name('township.index');
  Route::get('/admin/township/create', [TownshipController::class, 'create'])->middleware('permission:create,townships')->name('township.create');
  Route::post('/admin/township/store', [TownshipController::class, 'store'])->middleware('permission:create,townships')->name('township.store');
  Route::get('/admin/township/{township}/edit', [TownshipController::class, 'edit'])->middleware('permission:update,townships')->name('township.edit');
  Route::patch('/admin/township/{township}/update', [TownshipController::class, 'update'])->middleware('permission:update,townships')->name('township.update');
  Route::delete('/admin/township/{township}/delete', [TownshipController::class, 'delete'])->middleware('permission:delete,townships')->name('township.delete');
  Route::delete('/township/bulk-delete', [TownshipController::class, 'bulkDelete'])->middleware('permission:delete,townships')->name('township.bulkDelete');
  // Township Route: End

});
          