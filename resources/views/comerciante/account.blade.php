@extends('layouts.layout')

@section('title', 'Mi Negocio - Comerciante')

@section('content')
<div class="container mt-5 pt-4 mb-5">
    
    <div class="row mb-5">
        <div class="col-12">
            <div class="p-4 p-md-5 shadow-sm d-flex align-items-center" style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%); border-radius: 24px; border: 1px solid rgba(0,0,0,0.05);">
                <div>
                    <h2 class="fw-bolder text-dark mb-1">¡Hola, {{ Auth::user()->nombre }}! 👋</h2>
                    <p class="text-secondary mb-0 fs-5">Este es el panel de control de tu negocio.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4"> 

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 24px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(123, 82, 217, 0.1); color: #7b52d9;">
                        <i class="bi bi-box-seam fs-1"></i> 
                    </div>
                    <h4 class="fw-bold mb-3 text-dark">Catálogo</h4>
                    <p class="text-secondary mb-4">Gestiona tus productos, precios, stock y categorías.</p>
                    <a href="{{ route('productos.index') }}" class="btn w-100 rounded-pill fw-bold py-2" style="background-color: rgba(123, 82, 217, 0.1); color: #7b52d9; border: none;">Gestionar Catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 24px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(255, 152, 0, 0.1); color: #f57c00;">
                        <i class="bi bi-shop fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-dark">Mi Negocio</h4>
                    <p class="text-secondary mb-4">Edita el nombre, descripción, contactos y ubicación de tu local.</p>
                    <a href="{{ route('comerciante.edit') }}" class="btn w-100 rounded-pill fw-bold py-2" style="background-color: rgba(255, 152, 0, 0.1); color: #f57c00; border: none;">Editar Negocio</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 24px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(108, 117, 125, 0.1); color: #6c757d;">
                        <i class="bi bi-person-gear fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-dark">Mi Cuenta</h4>
                    <p class="text-secondary mb-4">Cambia tu contraseña, email y ajustes de seguridad de tu usuario.</p>
                    <a href="{{ route('profile.edit') }}" class="btn w-100 rounded-pill fw-bold py-2" style="background-color: rgba(108, 117, 125, 0.1); color: #6c757d; border: none;">Editar Perfil</a>
                </div>
            </div>
        </div>

    </div>
@endsection