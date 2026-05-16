@extends('layouts.layout')

@section('title', __('comerciante.title'))

@section('content')
<div class="container mt-5 pt-4 mb-5">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 p-md-5 shadow-sm d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3" style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%); border-radius: 24px; border: 1px solid rgba(0,0,0,0.05);">
                <div>
                    <h2 class="fw-bolder text-dark mb-1">{{ __('comerciante.welcome', ['name' => Auth::user()->nombre]) }}</h2>
                    <p class="text-secondary mb-0 fs-5">{{ __('comerciante.subtitle') }}</p>
                </div>
                
                @php $estado = Auth::user()->negocio->estado_validacion; @endphp
                
                @if($estado === 'pendiente')
                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2 align-self-start align-self-sm-center fw-bold">
                        <i class="bi bi-clock-history me-1"></i> {{ __('comerciante.status_pending') }}
                    </span>
                @elseif($estado === 'aprobado')
                    <span class="badge rounded-pill bg-success px-3 py-2 align-self-start align-self-sm-center fw-bold text-white">
                        <i class="bi bi-check-circle me-1"></i> {{ __('comerciante.status_approved') }}
                    </span>
                @elseif($estado === 'rechazado')
                    <span class="badge rounded-pill bg-danger px-3 py-2 align-self-start align-self-sm-center fw-bold text-white">
                        <i class="bi bi-x-circle me-1"></i> {{ __('comerciante.status_rejected') }}
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
                        <strong class="text-dark">{{ __('comerciante.alert_pending_title') }}</strong> 
                        {{ __('comerciante.alert_pending_desc') }}
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
                        <strong style="color: #b02a37;">{{ __('comerciante.alert_rejected_title') }}</strong> 
                        {{ __('comerciante.alert_rejected_desc') }}
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
                    <h4 class="fw-bold mb-3 text-dark">{{ __('comerciante.card_catalog_title') }}</h4>
                    <p class="text-secondary mb-4">{{ __('comerciante.card_catalog_desc') }}</p>
                    
                    @if($estado === 'aprobado')
                        <a href="{{ route('productos.index') }}" class="btn w-100 rounded-pill fw-bold py-2" style="background-color: rgba(123, 82, 217, 0.1); color: #7b52d9; border: none;">{{ __('comerciante.card_catalog_btn') }}</a>
                    @else
                        <button class="btn w-100 rounded-pill fw-bold py-2 border-0" style="background-color: #e9ecef; color: #adb5bd;" disabled>{{ __('comerciante.btn_locked') }}</button>
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
                    <h4 class="fw-bold mb-3 text-dark">{{ __('comerciante.card_business_title') }}</h4>
                    <p class="text-secondary mb-4">{{ __('comerciante.card_business_desc') }}</p>
                    
                    @if($estado === 'aprobado')
                        <a href="{{ route('comerciante.edit') }}" class="btn w-100 rounded-pill fw-bold py-2" style="background-color: rgba(255, 152, 0, 0.1); color: #f57c00; border: none;">{{ __('comerciante.card_business_btn') }}</a>
                    @else
                        <button class="btn w-100 rounded-pill fw-bold py-2 border-0" style="background-color: #e9ecef; color: #adb5bd;" disabled>{{ __('comerciante.btn_locked') }}</button>
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
                    <h4 class="fw-bold mb-3 text-dark">{{ __('comerciante.card_account_title') }}</h4>
                    <p class="text-secondary mb-4">{{ __('comerciante.card_account_desc') }}</p>
                    <a href="{{ route('profile.edit') }}" class="btn w-100 rounded-pill fw-bold py-2" style="background-color: rgba(108, 117, 125, 0.1); color: #6c757d; border: none;">{{ __('comerciante.card_account_btn') }}</a>
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
                    <h4 class="fw-bold mb-3 text-dark">{{ __('comerciante.card_orders_title') }}</h4>
                    <p class="text-secondary mb-4">{{ __('comerciante.card_orders_desc') }}</p>
                    
                    @if($estado === 'aprobado')
                        <a href="{{ route('negocios.reservas') }}" class="btn w-100 rounded-pill fw-bold py-2" 
                        style="background-color: rgba(25, 135, 84, 0.1); color: #198754; border: none;">
                        {{ __('comerciante.card_orders_btn') }}
                        </a>
                    @else
                        <button class="btn w-100 rounded-pill fw-bold py-2 border-0" 
                                style="background-color: #e9ecef; color: #adb5bd;" disabled>{{ __('comerciante.btn_locked') }}</button>
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
                        {{ __('comerciante.new_messages', ['count' => $mensajesNuevos]) }}
                    </span>
                @endif

                <div class="card-body p-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" 
                        style="width: 80px; height: 80px; background-color: #e8f3ee; color: #2e7d32;">
                        <i class="bi bi-chat-square-text fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3 text-dark">{{ __('comerciante.card_forum_title') }}</h4>
                    <p class="text-secondary mb-4">{{ __('comerciante.card_forum_desc') }}</p>
                    
                    @if($estado === 'aprobado')
                        <a href="{{ route('foros.show', $user->negocio->id) }}" class="btn w-100 rounded-pill fw-bold py-2" 
                        style="background-color: #e8f3ee; color: #2e7d32; border: none;">
                        {{ __('comerciante.card_forum_btn') }}
                        </a>
                    @else
                        <button class="btn w-100 rounded-pill fw-bold py-2 border-0" 
                                style="background-color: #e9ecef; color: #adb5bd;" disabled>{{ __('comerciante.btn_locked') }}</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection