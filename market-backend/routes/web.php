<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AuthController;

Route::get('/', IndexController::class)->name('index');

// Rutas de Registro
Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.post');

// NUEVAS: Rutas de Login y Logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// cuentas (Protegidos por Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/account', [AuthController::class, 'accountCliente'])->name('account');
    Route::get('/comerciante/account', [AuthController::class, 'accountComerciante'])->name('comerciante.account');
    Route::get('/admin/account', [AuthController::class, 'accountAdmin'])->name('admin.account');
});