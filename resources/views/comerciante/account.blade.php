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
                    <h4 class="fw-bold mb-3 text-dark">Mis Productos</h4>
                    <p class="text-secondary mb-4">Añade nuevos artículos, edita precios o gestiona el stock de tu catálogo.</p>
                    
                    <button class="btn w-100 rounded-pill fw-bold py-2" style="background-color: rgba(123, 82, 217, 0.1); color: #7b52d9; border: none; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#7b52d9'; this.style.color='white'" onmouseout="this.style.backgroundColor='rgba(123, 82, 217, 0.1)'; this.style.color='#7b52d9'">
                        Gestionar Catálogo
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 24px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(23, 162, 184, 0.1); color: #17a2b8;">
                        <i class="bi bi-geo-alt fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-dark">Mi Ubicación</h4>
                    <p class="text-secondary mb-3">Establece dónde te encuentran tus clientes dependiendo de tu tipo de venta.</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <span class="badge rounded-pill fw-normal" style="background-color: #e0f7fa; color: #00838f; padding: 6px 12px; border: 1px solid rgba(0, 131, 143, 0.2);">
                            <i class="bi bi-shop me-1"></i> Local Fijo
                        </span>
                        <span class="badge rounded-pill fw-normal" style="background-color: #fff3e0; color: #ef6c00; padding: 6px 12px; border: 1px solid rgba(239, 108, 0, 0.2);">
                            <i class="bi bi-truck me-1"></i> Ambulante
                        </span>
                    </div>
                    
                    <button class="btn w-100 rounded-pill fw-bold py-2" style="background-color: rgba(23, 162, 184, 0.1); color: #17a2b8; border: none; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#17a2b8'; this.style.color='white'" onmouseout="this.style.backgroundColor='rgba(23, 162, 184, 0.1)'; this.style.color='#17a2b8'">
                        Configurar Ubicación
                    </button>
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
                    <p class="text-secondary mb-4">Cambia tu contraseña, edita tus datos personales y ajusta tus preferencias.</p>
                    
                    <a href="{{ route('profile.edit') }}" class="btn w-100 rounded-pill fw-bold py-2 text-decoration-none" style="background-color: rgba(108, 117, 125, 0.1); color: #6c757d; border: none; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='white'" onmouseout="this.style.backgroundColor='rgba(108, 117, 125, 0.1)'; this.style.color='#6c757d'">
                        Editar Perfil
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection