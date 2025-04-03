<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AlmacenController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|

Route::middleware(['auth', 'can:users.index'])->group(function () {
    Route::resource('/users', UsuarioController::class)->names('users');
});
*/

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');



Route::group(['middleware' => 'auth'], function() {
    Route::resource('users', UsuarioController::class)->except([
        'show'
    ]);
    Route::resource('almacen', AlmacenController::class)->except([
        'show'
    ]);

    Route::get('/almacen/karness/{almacen}/{id}', [AlmacenController::class, 'karness'])->name('almacen.karness');

    
});

require __DIR__.'/auth.php';
