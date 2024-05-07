<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/pizza', [App\Http\Controllers\PizzaController::class, 'index'])->name('pizza.index');
    Route::get('/pizza/create', [App\Http\Controllers\PizzaController::class, 'create'])->name('pizza.create');
    Route::get('/pizza/{id}/edit', [App\Http\Controllers\PizzaController::class, 'edit'])->name('pizza.edit');

    Route::post('/pizza/store', [App\Http\Controllers\PizzaController::class, 'store'])->name('pizza.store');

    Route::put('/pizza/{id}/update', [App\Http\Controllers\PizzaController::class, 'update'])->name('pizza.update');

    Route::delete('/pizza/{id}/delete', [App\Http\Controllers\PizzaController::class, 'destroy'])->name('pizza.destroy');
    
    Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/user-create', [\App\Http\Controllers\AdminController::class, 'user_create'])->name('admin.user-create');
    Route::post('/admin/user/register', [\App\Http\Controllers\AdminController::class, 'register'])->name('admin.register') ;
});