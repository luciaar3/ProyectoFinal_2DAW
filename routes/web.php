<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ForumController;

Route::get('/', IndexController::class)->name('index');

// Rutas de Registro
Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.post');

//Rutas de Login y Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// cuentas (Protegidos por Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/account', [AuthController::class, 'accountCliente'])->name('cliente.account');
    Route::get('/comerciante/account', [AuthController::class, 'accountComerciante'])->name('comerciante.account');
    Route::get('/admin/account', [AuthController::class, 'accountAdmin'])->name('admin.account');

    Route::get('/mi-perfil', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::put('/mi-perfil', [ProfileController::class, 'updateProfile'])->name('profile.update');

});

//Notificaciones
Route::resource('notifications', NotificationController::class);

//Foros
Route::resource('forums', ForumController::class);

