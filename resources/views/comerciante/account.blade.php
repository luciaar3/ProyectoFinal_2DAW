@extends('layouts.layout')

@section('title', 'Mi Negocio - Comerciante')

@section('content')
<div class="container mt-5 pt-4 mb-5">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 p-md-5 shadow-sm d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3" style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%); border-radius: 24px; border: 1px solid rgba(0,0,0,0.05);">
                <div>
                    <h2 class="fw-bolder text-dark mb-1">¡Hola, {{ Auth::user()->nombre }}! 👋</h2>
                    <p class="text-secondary mb-0 fs-5">Este es el panel de control de tu negocio.</p>
                </div>
                
                @php $estado = Auth::user()->negocio->estado_validacion; @endphp
                
                @if($estado === 'pendiente')
                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2 align-self-start align-self-sm-center fw-bold">
                        <i class="bi bi-clock-history me-1"></i> Revisión Pendiente
                    </span>
                @elseif($estado === 'aprobado')
                    <span class="badge rounded-pill bg-success px-3 py-2 align-self-start align-self-sm-center fw-bold text-white">
                        <i class="bi bi-check-circle me-1"></i> Validado
                    </span>
                @elseif($estado === 'rechazado')
                    <span class="badge rounded-pill bg-danger px-3 py-2 align-self-start align-self-sm-center fw-bold text-white">
                        <i class="bi bi-x-circle me-1"></i> Solicitud Rechazada
                    </span>
                @endif
            </div>
        </div>
    </div>

    @if($estado === 'pendiente')
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-0" style="border-radius: 20px; background-color: #fff3cd;">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-warning"></i>
                    <div>
                        <strong class="text-dark">Cuenta en espera de revisión:</strong> 
                        Tu negocio está siendo verificado por el administrador. Podrás gestionar productos y rutas en cuanto recibas la aprobación.
                    </div>
                </div>
            </div>
        </div>
    @elseif($estado === 'rechazado')
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-0" style="border-radius: 20px; background-color: #f8d7da; color: #842029;">
                    <i class="bi bi-x-octagon-fill fs-4 me-3 text-danger"></i>
                    <div>
                        <strong style="color: #b02a37;">Acceso Denegado:</strong> 
                        La documentación presentada no cumple con los requisitos de la plataforma. Ponte en contacto con soporte si crees que se trata de un error.
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row g-4"> 

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm {{ $estado !== 'aprobado' ? 'opacity-75' : '' }}" 
                 style="border-radius: 24px; transition: transform 0.3s; {{ $estado !== 'aprobado' ? 'cursor: not-allowed;' : '' }}" 
                 @if($estado === 'aprobado') onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" @endif>
                <div class="card-body p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(123, 82, 217, 0.1); color: #7b52d9;">
                        <i class="bi bi-box-seam fs-1"></i> 
                    </div>
                    <h4 class="fw-bold mb-3 text-dark">Catálogo</h4>
                    <p class="text-secondary mb-4">Gestiona tus productos, precios, stock y categorías.</p>
                    
                    @if($estado === 'aprobado')
                        <a href="{{ route('productos.index') }}" class="btn w-100 rounded-pill fw-bold py-2" style="background-color: rgba(123, 82, 217, 0.1); color: #7b52d9; border: none;">Gestionar Catálogo</a>
                    @else
                        <button class="btn w-100 rounded-pill fw-bold py-2 border-0" style="background-color: #e9ecef; color: #adb5bd;" disabled>Bloqueado</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm {{ $estado !== 'aprobado' ? 'opacity-75' : '' }}" 
                 style="border-radius: 24px; transition: transform 0.3s; {{ $estado !== 'aprobado' ? 'cursor: not-allowed;' : '' }}"
                 @if($estado === 'aprobado') onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" @endif>
                <div class="card-body p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background-color: rgba(255, 152, 0, 0.1); color: #f57c00;">
                        <i class="bi bi-shop fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-dark">Mi Negocio</h4>
                    <p class="text-secondary mb-4">Edita el nombre, descripción, contactos y ubicación de tu local.</p>
                    
                    @if($estado === 'aprobado')
                        <a href="{{ route('comerciante.edit') }}" class="btn w-100 rounded-pill fw-bold py-2" style="background-color: rgba(255, 152, 0, 0.1); color: #f57c00; border: none;">Editar Negocio</a>
                    @else
                        <button class="btn w-100 rounded-pill fw-bold py-2 border-0" style="background-color: #e9ecef; color: #adb5bd;" disabled>Bloqueado</button>
                    @endif
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

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm {{ $estado !== 'aprobado' ? 'opacity-75' : '' }}" 
                style="border-radius: 24px; transition: transform 0.3s; {{ $estado !== 'aprobado' ? 'cursor: not-allowed;' : '' }}"
                @if($estado === 'aprobado') onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" @endif>
                <div class="card-body p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" 
                        style="width: 80px; height: 80px; background-color: rgba(25, 135, 84, 0.1); color: #198754;">
                        <i class="bi bi-calendar-check fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-dark">Reservas</h4>
                    <p class="text-secondary mb-4">Consulta los pedidos de tus clientes y gestiona sus variantes y estados.</p>
                    
                    @if($estado === 'aprobado')
                        <a href="{{ route('negocios.reservas') }}" class="btn w-100 rounded-pill fw-bold py-2" 
                        style="background-color: rgba(25, 135, 84, 0.1); color: #198754; border: none;">
                        Ver Pedidos
                        </a>
                    @else
                        <button class="btn w-100 rounded-pill fw-bold py-2 border-0" 
                                style="background-color: #e9ecef; color: #adb5bd;" disabled>Bloqueado</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm position-relative {{ $estado !== 'aprobado' ? 'opacity-75' : '' }}" 
                style="border-radius: 24px; transition: transform 0.3s; {{ $estado !== 'aprobado' ? 'cursor: not-allowed;' : '' }}"
                @if($estado === 'aprobado') onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'" @endif>
                
                @if($estado === 'aprobado' && $mensajesNuevos > 0)
                    <span class="position-absolute badge rounded-pill border border-2 border-white shadow-sm" 
                          style="top: 20px; right: 20px; background-color: #f53003; color: white; font-size: 0.85rem; padding: 6px 10px;">
                        {{ $mensajesNuevos }} nuevos
                    </span>
                @endif

                <div class="card-body p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" 
                        style="width: 80px; height: 80px; background-color: #e8f3ee; color: #2e7d32;">
                        <i class="bi bi-chat-square-text fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-dark">Foro Consultas</h4>
                    <p class="text-secondary mb-4">Atiende y responde las dudas de tus clientes de las últimas 24 horas.</p>
                    
                    @if($estado === 'aprobado')
                        <a href="{{ route('foros.show', $user->negocio->id) }}" class="btn w-100 rounded-pill fw-bold py-2" 
                        style="background-color: #e8f3ee; color: #2e7d32; border: none;">
                        Ver Foro
                        </a>
                    @else
                        <button class="btn w-100 rounded-pill fw-bold py-2 border-0" 
                                style="background-color: #e9ecef; color: #adb5bd;" disabled>Bloqueado</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection