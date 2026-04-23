<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComercianteController;
use App\Http\Controllers\NegocioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\NotificationController;

// --- RUTAS TOTALMENTE PÚBLICAS ---
Route::get('/', IndexController::class)->name('index');

// Rutas de Registro
Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.post');

// Rutas de Login y Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// RUTAS DE CONSULTA (Ahora accesibles sin login)
// Esto permite que los clientes busquen y vean los puestos y sus productos
Route::get('/buscar', [NegocioController::class, 'index'])->name('negocios.index');
Route::get('/negocio/{negocio}', [NegocioController::class, 'show'])->name('negocios.show');


// --- RUTAS PROTEGIDAS (Requieren estar logueado) ---
Route::middleware(['auth'])->group(function () {

    Route::get('/account', [AuthController::class, 'accountCliente'])->name('cliente.account');

    // Gestión del Comerciante (Solo el dueño puede tocar esto)
    Route::delete('/comerciante/imagen/{imagen}', [ComercianteController::class, 'destroyImagen'])->name('comerciante.imagen.destroy');
    Route::post('/comerciante/guardar-galeria', [ComercianteController::class, 'storeImagenes'])->name('comerciante.galeria.store');
    Route::get('/comerciante/editar-negocio', [ComercianteController::class, 'edit'])->name('comerciante.edit');
    Route::put('/comerciante/editar-negocio', [ComercianteController::class, 'update'])->name('comerciante.update');
    Route::get('/comerciante/account', [ComercianteController::class, 'account'])->name('comerciante.account');

    // Gestión del Catálogo (Solo el dueño crea/edita/borra)
    Route::get('/comerciante/catalogo', [ProductoController::class, 'index'])->name('productos.index');
    Route::post('/comerciante/catalogo', [ProductoController::class, 'store'])->name('productos.store');
    Route::put('/comerciante/catalogo/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/comerciante/catalogo/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // Admin y Perfil
    Route::get('/admin/account', [AuthController::class, 'accountAdmin'])->name('admin.account');

    Route::get('/mi-perfil', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::put('/mi-perfil', [ProfileController::class, 'updateProfile'])->name('profile.update');

});

//Notificaciones
Route::resource('notifications', NotificationController::class);

