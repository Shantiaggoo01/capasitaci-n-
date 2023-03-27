<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedoreController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Models\Producto;
use Spatie\Permission\Commands\Show;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/dashboard');
})->middleware('auth');
Route::get('/dashboard', [App\Http\Controllers\Dashboard::class,'index'])->middleware('auth');
// Controladores de el video
Route::post('/user/{id}/image', [App\Http\Controllers\UsuarioController::class, 'uploadImage'])->middleware('auth');


Route::group(['middleware'=>['auth']],function(){

Route::resource('usuarios', App\Http\Controllers\UsuarioController::class)->middleware('auth');
Route::resource('roles', App\Http\Controllers\RolController::class)->middleware('auth');
Route::resource('proveedores',App\Http\Controllers\ProveedoreController::class)->middleware('auth');

Route::resource('detalle-compra', App\Http\Controllers\DetalleCompraController::class)->middleware('auth');
Route::resource('productos', App\Http\Controllers\ProductoController::class)->middleware('auth');
Route::resource('tipo-proveedors', App\Http\Controllers\TipoProveedorController::class)->middleware('auth');
Route::resource('insumos', App\Http\Controllers\InsumoController::class)->middleware('auth');
Route::resource('clientes', App\Http\Controllers\ClienteController::class)->middleware('auth');
Route::resource('tipo-clientes', App\Http\Controllers\TipoClienteController::class)->middleware('auth');
Route::resource('ventas', App\Http\Controllers\VentaController::class)->middleware('auth');
Route::resource('detalle_ventas', App\Http\Controllers\DetalleVentasController::class);
Route::resource('produccion', App\Http\Controllers\ProduccionController::class)->middleware('auth');
Route::post('proveedor/{id}/estado', [ProveedoreController::class, 'updateStatus'])->name('provider.updateStatus');
Route::post('producto/{id}/estado', [ProductoController::class, 'updateStatus'])->name('producto.updateStatus');
Route::post('insumo/{id}/Estado', 'App\Http\Controllers\InsumoController@updateStatus')->name('insumo.updateStatus');
Route::post('cliente/{id}/Estado', 'App\Http\Controllers\ClienteController@updateStatus')->name('cliente.updateStatus');
//Route::delete('/productos/{producto}', [ProductosController::class, 'destroy'])->name('productos.destroy');

Route::get('/perfil', 'App\Http\Controllers\UsuarioController@showPerfil')->name('perfil');

Route::post('/usuarios/{id}/activar', 'App\Http\Controllers\UsuarioController@activar')->name('usuarios.activar');
Route::post('/usuarios/{id}/desactivar', 'App\Http\Controllers\UsuarioController@desactivar')->name('usuarios.desactivar');
Route::get('/roles/{id}/permissions', [RolController::class, 'showPermissions'])->name('roles.showPermissions');

Route::get('/ayuda', 'App\Http\Controllers\AyudaController@index')->name('ayuda.index');


Route::get('/descargar-manual', function () {
    $archivo = public_path('ayudas/manual_instalacion.pdf');
    return response()->download($archivo);
})->name('ayuda.descargar');


Route::get('/descargar-instalacion', function () {
    $archivo = public_path('ayudas/ManualdeUsuarioTRYP(Final).pdf');
    return response()->download($archivo);
})->name('ayuda.descargar-instalacion');





Route::resource('compra_insumos', App\Http\Controllers\CompraInsumoController::class)->middleware('auth');


});


/*Route::resource('compras', App\Http\Controllers\CompraController::class)->middleware('auth');
Route::resource('detalle_compras', App\Http\Controllers\DetalleCompraController::class)->middleware('auth');


Route::resource('productos', App\Http\Controllers\ProductoController::class)->middleware('auth');
Route::resource('tipo-proveedors', App\Http\Controllers\TipoProveedorController::class)->middleware('auth');
Route::resource('proveedores', App\Http\Controllers\ProveedoreController::class)->middleware('auth');
Route::resource('insumos', App\Http\Controllers\InsumoController::class)->middleware('auth');
Route::resource('clientes', App\Http\Controllers\ClienteController::class)->middleware('auth');
Route::resource('tipo-clientes', App\Http\Controllers\TipoClienteController::class)->middleware('auth');
Route::resource('ventas', App\Http\Controllers\VentaController::class)->middleware('auth');
*/
Auth::routes();

Route::get('/', [App\Http\Controllers\Dashboard::class, 'index'])->name('home')->middleware('auth');
