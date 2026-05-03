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
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                        <!-- Cabecera de la tarjeta con color del estado -->
                        <div class="p-3 bg-opacity-10 
                            @if($reserva->state == 'sent') bg-success text-success 
                            @elseif($reserva->state == 'due') bg-warning text-warning 
                            @else bg-danger text-danger @endif">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge 
                                    @if($reserva->state == 'sent') bg-success 
                                    @elseif($reserva->state == 'due') bg-warning text-dark 
                                    @else bg-danger @endif rounded-pill px-3 py-2">
                                    {{ ucfirst($reserva->state) }}
                                </span>
                                <small class="fw-bold">{{ \Carbon\Carbon::parse($reserva->creation)->format('d/m/Y') }}</small>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $reserva->producto->imagen ? asset('storage/'.$reserva->producto->imagen) : 'https://via.placeholder.com/60' }}" 
                                     class="rounded-3 object-fit-cover me-3 shadow-sm" style="width: 60px; height: 60px;">
                                <div>
                                    <h5 class="fw-bold mb-0 text-truncate" style="max-width: 200px;">{{ $reserva->producto->nombre }}</h5>
                                    <p class="text-muted small mb-0"><i class="fas fa-store me-1"></i> {{ $reserva->producto->negocio->nombre_negocio }}</p>
                                </div>
                            </div>
                            
                            <hr class="my-3 text-muted">
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">Cantidad:</span>
                                <span class="fw-bold">{{ $reserva->quantity }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-secondary">Precio Total:</span>
                                <span class="fw-bold text-sage fs-5">{{ number_format($reserva->cost, 2) }}€</span>
                            </div>

                            <div class="d-grid mt-auto">
                                <button class="btn btn-outline-dark rounded-pill py-2 fw-bold w-100" data-bs-toggle="modal" data-bs-target="#modalReserva{{ $reserva->id }}">
                                    Ver Detalles
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Detalles de Reserva -->
                <div class="modal fade" id="modalReserva{{ $reserva->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 rounded-5 overflow-hidden">
                            <div class="modal-body p-4 text-center">
                                <div class="mb-4">
                                    <img src="{{ $reserva->producto->imagen ? asset('storage/'.$reserva->producto->imagen) : 'https://via.placeholder.com/150' }}" class="rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                                </div>
                                <h3 class="fw-bold mb-1">{{ $reserva->producto->nombre }}</h3>
                                <p class="text-muted mb-4">Vendido por <strong>{{ $reserva->producto->negocio->nombre_negocio }}</strong></p>
                                
                                <div class="bg-light rounded-4 p-3 mb-4 text-start">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Fecha de reserva:</span>
                                        <span>{{ \Carbon\Carbon::parse($reserva->creation)->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Expira el:</span>
                                        <span>{{ \Carbon\Carbon::parse($reserva->expiraton)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Cantidad reservada:</span>
                                        <span>{{ $reserva->quantity }} unidades</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-secondary">Total a pagar:</span>
                                        <span class="fw-bold fs-4 text-sage">{{ number_format($reserva->cost, 2) }}€</span>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="tel:{{ $reserva->producto->negocio->telefono }}" class="btn btn-outline-dark rounded-pill py-2 fw-bold">
                                        <i class="fas fa-phone-alt me-2"></i> Contactar al vendedor
                                    </a>
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
</style>
@endsection
