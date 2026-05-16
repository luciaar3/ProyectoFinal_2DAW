@extends('layouts.layout')

@section('title', __('bookings.page_title'))

@section('content')
<div class="container mt-5 pt-4 mb-5">
    
    <div class="row mb-5">
        <div class="col-12">
            <div class="p-4 p-md-5 shadow-sm d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-4" 
                 style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%); border-radius: 24px; border: 1px solid rgba(0,0,0,0.05);">
                <div>
                    <span class="badge mb-1 text-white px-3 py-1 rounded-pill" style="background-color: #f53003; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">{{ __('bookings.badge') }}</span>
                    <h1 class="fw-bolder text-dark mb-1" style="letter-spacing: -1px;">{{ __('bookings.title') }}</h1>
                    <p class="text-secondary mb-0 fs-5">{{ __('bookings.subtitle') }}</p>
                </div>
                <div>
                    <a href="{{ route('cliente.account') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm transition-hover bg-white">
                        <i class="bi bi-arrow-left me-2"></i>{{ __('bookings.back_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 p-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($reservas->isEmpty())
        <div class="row justify-content-center py-5">
            <div class="col-12 text-center">
                <div class="p-5 bg-white shadow-sm mx-auto" style="border-radius: 24px; max-width: 500px; border: 1px solid rgba(0,0,0,0.05);">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 80px; height: 80px; background-color: #f8f9fa; color: #6c757d;">
                        <i class="bi bi-box-seam fs-1"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-1">{{ __('bookings.empty_title') }}</h4>
                    <p class="text-muted small mb-4">{{ __('bookings.empty_desc') }}</p>
                    <a href="{{ route('negocios.index') }}" class="btn text-white rounded-pill px-4 fw-bold shadow-sm transition-hover" style="background-color: #f53003; border: none;">
                        <i class="bi bi-shop me-2"></i>{{ __('bookings.empty_btn') }}
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($reservas as $reserva)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm transition-hover d-flex flex-column" style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.03) !important; overflow: hidden;">
                        
                        <div class="p-3 bg-opacity-10 
                            @if($reserva->estado == 'completada') bg-success text-success 
                            @elseif($reserva->estado == 'pendiente') bg-warning text-warning 
                            @else bg-danger text-danger @endif" style="background-color: currentcolor;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge rounded-pill px-3 py-1.5 fw-bold text-uppercase d-flex align-items-center gap-1
                                    @if($reserva->estado == 'completada') bg-success text-white
                                    @elseif($reserva->estado == 'pendiente') bg-warning text-dark 
                                    @else bg-danger text-white @endif" style="font-size: 0.7rem;">
                                    <i class="bi @if($reserva->estado == 'completada') bi-check-circle-fill @elseif($reserva->estado == 'pendiente') bi-hourglass-split @else bi-x-circle-fill @endif"></i>
                                    {{ __('bookings.status_' . $reserva->estado) }}
                                </span>
                                <small class="fw-bold text-dark opacity-75 d-flex align-items-center gap-1">
                                    <i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($reserva->fecha_creacion)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>

                        <div class="card-body p-4 d-flex flex-column flex-grow-1">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ $reserva->producto->imagen ? asset('storage/'.$reserva->producto->imagen) : 'https://via.placeholder.com/100x100?text='.urlencode($reserva->producto->nombre) }}" 
                                     class="rounded-4 object-fit-cover me-3 shadow-sm" style="width: 64px; height: 64px; border: 1px solid rgba(0,0,0,0.05);">
                                <div class="overflow-hidden">
                                    <h5 class="fw-bolder mb-1 text-dark text-truncate" style="letter-spacing: -0.3px;">{{ $reserva->producto->nombre }}</h5>
                                    <p class="text-secondary small mb-0 text-truncate">
                                        <i class="bi bi-shop me-1"></i> {{ $reserva->producto->negocio->nombre_negocio ?? __('bookings.default_merchant') }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-3 rounded-4 mb-4 border-start border-4 text-dark" style="background-color: #f8f9fa; border-color: #37474f !important;">
                                <small class="text-muted d-block fw-bold text-uppercase mb-1.5" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                    <i class="bi bi-geo-alt-fill text-dark me-1"></i> {{ __('bookings.pickup_point') }}
                                </small>
                                @if($reserva->lugarRecogida)
                                    <p class="mb-1 small fw-bold text-truncate">{{ $reserva->lugarRecogida->ubicacion }}</p>
                                    <small class="text-secondary d-block" style="font-size: 0.75rem; line-height: 1.3;">
                                        {{ __('bookings.pickup_schedule', [
                                            'day' => __('bookings.day_' . strtolower($reserva->lugarRecogida->dia)),
                                            'open' => \Carbon\Carbon::parse($reserva->lugarRecogida->apertura)->format('H:i'),
                                            'close' => \Carbon\Carbon::parse($reserva->lugarRecogida->cierre)->format('H:i')
                                        ]) }}
                                    </small>
                                @else
                                    <p class="mb-0 small text-muted fst-italic">{{ __('bookings.no_pickup_specified') }}</p>
                                @endif
                            </div>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between mb-1.5">
                                    <span class="text-secondary small">{{ __('bookings.quantity') }}</span>
                                    <span class="fw-bold text-dark small">{{ $reserva->cantidad }} {{ $reserva->cantidad > 1 ? __('bookings.unit_plural') : __('bookings.unit_singular') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-4 align-items-center">
                                    <span class="text-secondary small">{{ __('bookings.total_amount') }}</span>
                                    <span class="fw-extrabold text-dark fs-4">{{ number_format($reserva->coste_total, 2, ',', '.') }}€</span>
                                </div>

                                <div class="row g-2">
                                    <div class="@if($reserva->estado == 'pendiente') col-8 @else col-12 @endif">
                                        <button class="btn btn-outline-dark rounded-pill py-2 fw-bold w-100 btn-sm transition-hover" data-bs-toggle="modal" data-bs-target="#modalReserva{{ $reserva->id }}">
                                            <i class="bi bi-info-circle me-1"></i> {{ __('bookings.details_btn') }}
                                        </button>
                                    </div>
                                    
                                    @if($reserva->estado == 'pendiente')
                                        <div class="col-4">
                                            <form action="{{ route('cliente.reservas.cancelar', $reserva->id) }}" method="POST" onsubmit="return confirm('{{ __('bookings.cancel_confirm_js') }}');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-outline-danger rounded-pill py-2 fw-bold w-100 btn-sm transition-hover" title="{{ __('bookings.cancel_btn_title') }}">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalReserva{{ $reserva->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 rounded-5 overflow-hidden shadow-lg bg-white">
                            <div class="modal-body p-4 text-center">
                                <div class="mb-3 position-relative d-inline-block">
                                    <img src="{{ $reserva->producto->imagen ? asset('storage/'.$reserva->producto->imagen) : 'https://via.placeholder.com/150x150' }}" class="rounded-circle shadow-sm object-fit-cover" style="width: 110px; height: 110px; border: 2px solid #f8f9fa;">
                                </div>
                                <h3 class="fw-bolder text-dark mb-1" style="letter-spacing: -0.5px;">{{ $reserva->producto->nombre }}</h3>
                                <p class="text-secondary small mb-4">{{ __('bookings.modal_sold_by') }} <strong>{{ $reserva->producto->negocio->nombre_negocio ?? __('bookings.default_merchant') }}</strong></p>
                                
                                <div class="bg-light rounded-4 p-3 mb-4 text-start">
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-white">
                                        <span class="text-secondary small">{{ __('bookings.modal_request_date') }}</span>
                                        <span class="fw-medium small text-dark">{{ \Carbon\Carbon::parse($reserva->fecha_creacion)->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-white">
                                        <span class="text-secondary small">{{ __('bookings.modal_variant') }}</span>
                                        <span class="fw-bold small text-dark">{{ $reserva->variante_elegida ?? __('bookings.modal_default_variant') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-white">
                                        <span class="text-secondary small">{{ __('bookings.quantity') }}</span>
                                        <span class="fw-medium small text-dark">{{ $reserva->cantidad }} {{ __('bookings.unit_plural') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary small">{{ __('bookings.modal_expiry') }}</span>
                                        <span class="text-danger fw-bold small"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ \Carbon\Carbon::parse($reserva->fecha_expiracion)->format('d/m/Y') }}</span>
                                    </div>

                                    <hr class="text-muted opacity-25 my-2.5">
                                    <div class="mb-1">
                                        <span class="text-secondary small d-block mb-1.5"><i class="bi bi-map text-dark me-1"></i> {{ __('bookings.modal_pickup_plan') }}</span>
                                        @if($reserva->lugarRecogida)
                                            <div class="p-2.5 bg-white rounded-3 border border-light-subtle">
                                                <p class="mb-0.5 small fw-bold text-dark">{{ $reserva->lugarRecogida->ubicacion }}</p>
                                                <p class="mb-1 small text-muted text-capitalize" style="font-size: 0.75rem;"><i class="bi bi-building me-1"></i> {{ $reserva->lugarRecogida->poblacion }}</p>
                                                <p class="mb-0 text-dark font-medium" style="font-size: 0.75rem;">
                                                    <i class="bi bi-clock me-1"></i> {{ __('bookings.modal_next_pickup', [
                                                        'day' => __('bookings.day_' . strtolower($reserva->lugarRecogida->dia)),
                                                        'open' => \Carbon\Carbon::parse($reserva->lugarRecogida->apertura)->format('H:i'),
                                                        'close' => \Carbon\Carbon::parse($reserva->lugarRecogida->cierre)->format('H:i')
                                                    ]) }}
                                                </p>
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic small">{{ __('bookings.no_pickup_specified') }}</span>
                                        @endif
                                    </div>

                                    <hr class="text-muted opacity-25 my-2.5">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-secondary small fw-bold">{{ __('bookings.modal_pay_at_stall') }}</span>
                                        <span class="fw-extrabold fs-4 text-dark">{{ number_format($reserva->coste_total, 2, ',', '.') }}€</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex flex-column gap-2">
                                    @if($reserva->producto->negocio->telefono)
                                        <a href="tel:{{ $reserva->producto->negocio->telefono }}" class="btn btn-outline-dark rounded-pill py-2 fw-bold w-100">
                                            <i class="bi bi-telephone-outbound me-2"></i> {{ __('bookings.modal_call_merchant') }}
                                        </a>
                                    @endif
                                    
                                    @if($reserva->estado == 'pendiente')
                                        <form action="{{ route('cliente.reservas.cancelar', $reserva->id) }}" method="POST" onsubmit="return confirm('{{ __('bookings.cancel_confirm_js') }}');" class="w-100">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger text-white rounded-pill py-2 fw-bold w-100" style="background-color: #f53003; border: none;">
                                                <i class="bi bi-x-circle me-2"></i> {{ __('bookings.modal_cancel_permanent') }}
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <button type="button" class="btn btn-light rounded-pill py-2 fw-bold text-secondary w-100" data-bs-dismiss="modal">{{ __('bookings.modal_close') }}</button>
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
    .transition-hover {
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
    }
    .object-fit-cover { object-fit: cover; }
    .fw-extrabold { font-weight: 800; }
</style>
@endsection