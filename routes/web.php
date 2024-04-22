<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ProveedorController;

use App\Http\Controllers\PresentacioneController;
use App\Http\Controllers\VentaController;

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

Route::get('/', function () {
    return view('template');
});

Route::get('/login', function () {
    return view('auth.login');
});
Route::view('/panel', 'panel.index')->name('panel');




Route::resources([
    'categorias'=>CategoriaController::class,
    'presentaciones' =>  PresentacioneController::class,
    'marcas' =>  MarcaController::class,
    'productos' => ProductoController::class,
    'clientes'=> ClienteController::class,
    'proveedores'=> ProveedorController::class,
    'compras'=> CompraController::class,
    'ventas' =>VentaController::class,
]);

Route::get('/401', function () {
    return view('pages.401');
});


Route::get('/404', function () {
    return view('pages.404');
});


Route::get('/500', function () {
    return view('pages.500');
});

