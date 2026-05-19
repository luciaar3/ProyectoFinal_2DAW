<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComercianteController;
use App\Http\Controllers\NegocioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ForoController;
use App\Http\Controllers\ClienteController;

// --- RUTAS TOTALMENTE PÚBLICAS ---
Route::get('/', IndexController::class)->name('index');

// Rutas de Registro
Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.post');

// Rutas de Login y Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// RUTAS DE CONSULTA (accesibles sin login)
Route::get('/buscar', [NegocioController::class, 'index'])->name('negocios.index');
Route::get('/negocio/{negocio}', [NegocioController::class, 'show'])->name('negocios.show');
Route::get('/panel-negocio/reservas', [NegocioController::class, 'misReservas'])->name('negocios.reservas');
Route::patch('/reservas/{reserva}/estado', [NegocioController::class, 'actualizarEstadoReserva'])->name('reservas.actualizarEstado');


// --- RUTAS PROTEGIDAS (Requieren estar logueado) ---
Route::middleware(['auth'])->group(function () {

    Route::get('/account', [AuthController::class, 'accountCliente'])->name('cliente.account');

    // Favoritos y Reservas
    Route::post('/productos/{producto}/favorito', [ClienteController::class, 'toggleFavorito'])->name('productos.favorito');
    Route::post('/productos/{producto}/reservar', [ClienteController::class, 'reservar'])->name('productos.reservar');
    Route::get('/mis-reservas', [ClienteController::class, 'misReservas'])->name('cliente.reservas');
    Route::put('/cliente/reservas/{id}/cancelar', [ClienteController::class, 'cancelarReserva'])->name('cliente.reservas.cancelar');
    Route::get('/mis-favoritos', [ClienteController::class, 'misFavoritos'])->name('cliente.favoritos');

    // Gestión del Comerciante
    Route::delete('/comerciante/imagen/{imagen}', [ComercianteController::class, 'destroyImagen'])->name('comerciante.imagen.destroy');
    Route::post('/comerciante/guardar-galeria', [ComercianteController::class, 'storeImagenes'])->name('comerciante.galeria.store');
    Route::get('/comerciante/editar-negocio', [ComercianteController::class, 'edit'])->name('comerciante.edit');
    Route::put('/comerciante/editar-negocio', [ComercianteController::class, 'update'])->name('comerciante.update');
    Route::get('/comerciante/account', [ComercianteController::class, 'account'])->name('comerciante.account');

    // Gestión del Catálogo
    Route::get('/comerciante/catalogo', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('productos.show');
    Route::post('/comerciante/catalogo', [ProductoController::class, 'store'])->name('productos.store');
    Route::put('/comerciante/catalogo/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/comerciante/catalogo/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    Route::delete('/comerciante/productos/variantes/{id}', [ProductoController::class, 'destroyVariante'])->name('productos.variante.destroy');

    // Rutas para la gestión de variantes
    Route::get('/comerciante/productos/{producto}/variantes', [ProductoController::class, 'getVariantes']);
    Route::post('/comerciante/productos/variantes', [ProductoController::class, 'addVariante']);

    //Foros
    Route::get('/foros', [ForoController::class, 'index'])->name('foros.index');
    Route::get('/foros/comercio/{id}', [ForoController::class, 'show'])->name('foros.show');
    Route::post('/foros/store', [ForoController::class, 'store'])->name('foros.store');

    Route::get('/mi-perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/mi-perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/mi-perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/account', [AdminController::class, 'account'])->name('admin.account');
    Route::get('/validaciones', [AdminController::class, 'index'])->name('admin.validaciones');
    Route::get('/usuarios', [AdminController::class, 'usersIndex'])->name('admin.users.index');
    Route::delete('/usuarios/{id}', [AdminController::class, 'userDestroy'])->name('admin.users.destroy');
    Route::post('/validaciones/{id}/aprobar', [AdminController::class, 'aprobar'])->name('admin.aprobar');
    Route::post('/validaciones/{id}/rechazar', [AdminController::class, 'rechazar'])->name('admin.rechazar');
});

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['es', 'ca', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

