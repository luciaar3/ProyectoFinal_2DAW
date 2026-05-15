@extends('layouts.layout')

@section('content')
<div class="container py-5 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="fw-bold" style="color: #2d2a26;">Mis Reservas</h2>
        <a href="{{ route('cliente.account') }}" class="btn btn-outline-secondary rounded-pill">Volver al Panel</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($reservas->isEmpty())
        <div class="text-center py-5 bg-white rounded-5 shadow-sm">
            <i class="fas fa-box-open fs-1 text-muted mb-3"></i>
            <h4 class="fw-bold text-dark">No tienes reservas activas</h4>
            <p class="text-secondary">Explora los comercios y reserva tus productos favoritos.</p>
            <a href="{{ route('negocios.index') }}" class="btn btn-primary rounded-pill mt-3 px-4" style="background-color: #6b7a63; border: none;">Ir a Comercios</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($reservas as $reserva)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative d-flex flex-column">
                        
                        <div class="p-3 bg-opacity-10 
                            @if($reserva->estado == 'completada') bg-success text-success 
                            @elseif($reserva->estado == 'pendiente') bg-warning text-warning 
                            @else bg-danger text-danger @endif">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge 
                                    @if($reserva->estado == 'completada') bg-success 
                                    @elseif($reserva->estado == 'pendiente') bg-warning text-dark 
                                    @else bg-danger @endif rounded-pill px-3 py-2">
                                    {{ ucfirst($reserva->estado) }}
                                </span>
                                <small class="fw-bold">{{ \Carbon\Carbon::parse($reserva->fecha_creacion)->format('d/m/Y') }}</small>
                            </div>
                        </div>

                        <div class="card-body p-4 d-flex flex-column flex-grow-1">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $reserva->producto->imagen ? asset('storage/'.$reserva->producto->imagen) : 'https://via.placeholder.com/60' }}" 
                                     class="rounded-3 object-fit-cover me-3 shadow-sm" style="width: 60px; height: 60px;">
                                <div class="overflow-hidden">
                                    <h5 class="fw-bold mb-0 text-truncate" style="max-width: 200px;">{{ $reserva->producto->nombre }}</h5>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-store me-1"></i> {{ $reserva->producto->negocio->nombre_negocio ?? 'Tienda' }}
                                    </p>
                                </div>
                            </div>

                            {{-- NUEVO: Bloque de Información del Mercadillo en la Tarjeta Principal --}}
                            <div class="p-3 bg-light rounded-4 mb-3 border-start border-4 border-sage">
                                <small class="text-muted d-block fw-bold text-uppercase tracking-wider mb-1" style="font-size: 0.7rem;">
                                    <i class="fas fa-map-marker-alt text-sage me-1"></i> Punto de recogida:
                                </small>
                                @if($reserva->lugarRecogida)
                                    <p class="mb-0 small text-dark fw-bold text-truncate">{{ $reserva->lugarRecogida->ubicacion }}</p>
                                    <small class="text-secondary d-block mt-1" style="font-size: 0.8rem;">
                                        Cada <strong>{{ ucfirst($reserva->lugarRecogida->dia) }}</strong> de {{ \Carbon\Carbon::parse($reserva->lugarRecogida->apertura)->format('H:i') }} a {{ \Carbon\Carbon::parse($reserva->lugarRecogida->cierre)->format('H:i') }}
                                    </small>
                                @else
                                    <p class="mb-0 small text-muted fst-italic">Puesto no especificado o cancelado</p>
                                @endif
                            </div>
                            
                            <hr class="my-2 text-muted mt-auto">
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary small">Cantidad:</span>
                                <span class="fw-bold small">{{ $reserva->cantidad }} uds.</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 align-items-center">
                                <span class="text-secondary small">Precio Total:</span>
                                <span class="fw-bold text-sage fs-5">{{ number_format($reserva->coste_total, 2, ',', '.') }}€</span>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-outline-dark rounded-pill py-2 fw-bold w-100" data-bs-toggle="modal" data-bs-target="#modalReserva{{ $reserva->id }}">
                                    Ver Detalles
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL DE DETALLES --}}
                <div class="modal fade" id="modalReserva{{ $reserva->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 rounded-5 overflow-hidden shadow-lg">
                            <div class="modal-body p-4 text-center">
                                <div class="mb-4">
                                    <img src="{{ $reserva->producto->imagen ? asset('storage/'.$reserva->producto->imagen) : 'https://via.placeholder.com/150' }}" class="rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                                </div>
                                <h3 class="fw-bold mb-1">{{ $reserva->producto->nombre }}</h3>
                                <p class="text-muted mb-4">Vendido por <strong>{{ $reserva->producto->negocio->nombre_negocio ?? 'Comercio' }}</strong></p>
                                
                                <div class="bg-light rounded-4 p-3 mb-4 text-start">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Fecha de reserva:</span>
                                        <span>{{ \Carbon\Carbon::parse($reserva->fecha_creacion)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Variante elegida:</span>
                                        <span class="fw-semibold text-dark">{{ $reserva->variante_elegida }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Cantidad:</span>
                                        <span>{{ $reserva->cantidad }} unidades</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Expira automáticamente:</span>
                                        <span class="text-danger fw-bold">{{ \Carbon\Carbon::parse($reserva->fecha_expiracion)->format('d/m/Y') }}</span>
                                    </div>

                                    {{-- NUEVO: Detalle ampliado del punto de recogida dentro del Modal --}}
                                    <hr class="text-muted my-3">
                                    <div class="mb-1">
                                        <span class="text-secondary d-block mb-1"><i class="fas fa-map-marked-alt text-sage me-1"></i> Información de Entrega:</span>
                                        @if($reserva->lugarRecogida)
                                            <div class="p-3 bg-white rounded-3 border border-light-subtle">
                                                <p class="mb-1 fw-bold text-dark">{{ $reserva->lugarRecogida->ubicacion }}</p>
                                                <p class="mb-1 small text-muted"><i class="fas fa-city me-1"></i> Localidad: {{ $reserva->lugarRecogida->poblacion }}</p>
                                                <p class="mb-0 small text-sage fw-medium">
                                                    <i class="far fa-calendar-alt me-1"></i> Próximo <strong>{{ ucfirst($reserva->lugarRecogida->dia) }}</strong> de {{ \Carbon\Carbon::parse($reserva->lugarRecogida->apertura)->format('H:i') }} a {{ \Carbon\Carbon::parse($reserva->lugarRecogida->cierre)->format('H:i') }}
                                                </p>
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic small">No se asignó punto fijo de entrega.</span>
                                        @endif
                                    </div>

                                    <hr class="text-muted my-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-secondary">Total a pagar en puesto:</span>
                                        <span class="fw-bold fs-4 text-sage">{{ number_format($reserva->coste_total, 2, ',', '.') }}€</span>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    @if($reserva->producto->negocio->telefono)
                                        <a href="tel:{{ $reserva->producto->negocio->telefono }}" class="btn btn-outline-dark rounded-pill py-2 fw-bold">
                                            <i class="fas fa-phone-alt me-2"></i> Contactar al vendedor
                                        </a>
                                    @endif
                                    <button type="button" class="btn btn-secondary rounded-pill py-2 fw-bold" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .text-sage { color: #4a5d4e !important; }
    .border-sage { border-color: #4a5d4e !important; }
    .object-fit-cover { object-fit: cover; }
</style>
@endsection