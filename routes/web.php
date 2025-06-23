<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ControlCebadoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\InsumosController;
use App\Http\Controllers\PermissionController;  
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PetitorioController;

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
Route::get('/', function () {
    return redirect('/login'); // Redirecciona a /ruta-destino
});

//Route::view('/', 'welcome');

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
    Route::resource('control_cebado',ControlCebadoController::class)->except([
        'show'
    ]);
    Route::resource('inventario', InventarioController::class)->except([
        'show'
    ]);

    Route::resource('movimiento_almacen', MovimientoController::class)->except([
        'show'
    ]);

    Route::resource('insumos', InsumosController::class)->except([
        'show'
    ]);

    Route::get('permisos', [PermissionController::class, 'index'])->name('permisos.index');
     

    
    Route::resource('roles', RoleController::class);
    


    Route::resource('petitorio', PetitorioController::class)->except([
        'show'
    ]);

    

    Route::get('/movimiento_almacen/get-movimientos/{insumoId}', [MovimientoController::class, 'getMovimientos']);


    Route::get('/movimiento_almacen/get-navegacion/{insumoId}', [MovimientoController::class, 'getNavegacion'])->name('movimiento_almacen.getNavegacion');

    Route::get('/movimiento_almacen/show-movimiento/{movimientoId}', [MovimientoController::class, 'showMovimiento'])->name('movimiento_almacen.showMovimiento');

    Route::post('/movimiento_almacen/store-movimiento', [MovimientoController::class, 'storeMovimiento'])->name('movimiento_almacen.storeMovimiento');

    Route::put('/movimiento_almacen/update-movimiento/{movimientoId}', [MovimientoController::class, 'updateMovimiento'])->name('movimiento_almacen.updateMovimiento');



    Route::get('/ruleFiltrosSet', [ControlCebadoController::class, 'ruleFiltrosSet'])->name('control_cebado.ruleFiltrosSet');

    Route::get('/table-control-cebado', [ControlCebadoController::class, 'table'])->name('control_cebado.table');
    
    Route::get('/almacen/karness/{almacen}/{insumoId}', [AlmacenController::class, 'karness'])->name('almacen.karness');


    
});

require __DIR__.'/auth.php';