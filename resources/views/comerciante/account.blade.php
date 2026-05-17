@extends('layouts.layout')

@section('title', __('comerciante.title'))

@section('content')
<div class="container mt-5 pt-4 mb-5">
    
    <div class="row mb-5">
        <div class="col-12">
            <div class="p-4 p-md-5 shadow-sm d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4 position-relative overflow-hidden text-white" 
                 style="background: linear-gradient(135deg, #f53003 0%, #ff6b4a 100%); border-radius: 24px;">
                
                <div class="position-absolute opacity-10" style="right: -20px; bottom: -30px; font-size: 12rem; line-height: 1;">
                    <i class="bi bi-shop-window"></i>
                </div>

                <div class="position-relative" style="z-index: 2;">
                    <span class="badge bg-white text-dark mb-2 px-3 py-1 rounded-pill fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        {{ strtoupper(__('comerciante.title')) }}
                    </span>
                    <h1 class="fw-bolder mb-1" style="letter-spacing: -1px;">
                        {{ __('comerciante.welcome', ['name' => Auth::user()->nombre]) }}
                    </h1>
                    <p class="mb-0 opacity-90 fs-5">{{ __('comerciante.subtitle') }}</p>
                </div>

                <div class="position-relative" style="z-index: 2;">
                    @php $estado = Auth::user()->negocio->estado_validacion; @endphp
                    
                    @if($estado === 'pendiente')
                        <span class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm border-0 text-dark d-inline-flex align-items-center gap-2" style="pointer-events: none;">
                            <i class="bi bi-clock-history fs-5"></i> {{ __('comerciante.status_pending') }}
                        </span>
                    @elseif($estado === 'aprobado')
                        <span class="btn btn-light rounded-pill px-4 fw-bold shadow-sm border-0 bg-white text-success d-inline-flex align-items-center gap-2" style="pointer-events: none;">
                            <i class="bi bi-check-circle-fill text-success fs-5"></i> {{ __('comerciante.status_approved') }}
                        </span>
                    @elseif($estado === 'rechazado')
                        <span class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm border-0 text-white d-inline-flex align-items-center gap-2" style="pointer-events: none;">
                            <i class="bi bi-x-circle fs-5"></i> {{ __('comerciante.status_rejected') }}
                        </span>
                    @endif
                </div>
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
            <div class="card h-100 border-0 shadow-sm transition-hover {{ $estado !== 'aprobado' ? 'card-locked' : '' }}" 
                 style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.03) !important;">
                <div class="card-body p-4 d-flex flex-column align-items-start">
                    <div class="p-3 rounded-4 mb-4 d-inline-flex text-white shadow-sm" style="background: linear-gradient(135deg, #2e7d32, #43a047); border-radius: 18px !important;">
                        <i class="bi bi-box-seam fs-3"></i> 
                    </div>
                    <h4 class="fw-bolder text-dark mb-2" style="letter-spacing: -0.5px;">{{ __('comerciante.card_catalog_title') }}</h4>
                    <p class="text-secondary small flex-grow-1" style="line-height: 1.5;">{{ __('comerciante.card_catalog_desc') }}</p>
                    
                    @if($estado === 'aprobado')
                        <a href="{{ route('productos.index') }}" class="btn w-100 rounded-pill fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2 mt-3" 
                           style="background-color: #e8f3ee; color: #2e7d32; border: none;">
                            {{ __('comerciante.card_catalog_btn') }} <i class="bi bi-arrow-right small"></i>
                        </a>
                    @else
                        <button class="btn w-100 rounded-pill fw-bold py-2.5 border-0 mt-3" style="background-color: #e9ecef; color: #adb5bd;" disabled>
                            <i class="bi bi-lock-fill me-1 small"></i> {{ __('comerciante.btn_locked') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm transition-hover {{ $estado !== 'aprobado' ? 'card-locked' : '' }}" 
                 style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.03) !important;">
                <div class="card-body p-4 d-flex flex-column align-items-start">
                    <div class="p-3 rounded-4 mb-4 d-inline-flex text-white shadow-sm" style="background: linear-gradient(135deg, #0288d1, #039be5); border-radius: 18px !important;">
                        <i class="bi bi-calendar-check fs-3"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-2" style="letter-spacing: -0.5px;">{{ __('comerciante.card_orders_title') }}</h4>
                    <p class="text-secondary small flex-grow-1" style="line-height: 1.5;">{{ __('comerciante.card_orders_desc') }}</p>
                    
                    @if($estado === 'aprobado')
                        <a href="{{ route('negocios.reservas') }}" class="btn w-100 rounded-pill fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2 mt-3" 
                           style="background-color: #e1f5fe; color: #0288d1; border: none;">
                            {{ __('comerciante.card_orders_btn') }} <i class="bi bi-arrow-right small"></i>
                        </a>
                    @else
                        <button class="btn w-100 rounded-pill fw-bold py-2.5 border-0 mt-3" style="background-color: #e9ecef; color: #adb5bd;" disabled>
                            <i class="bi bi-lock-fill me-1 small"></i> {{ __('comerciante.btn_locked') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm position-relative transition-hover {{ $estado !== 'aprobado' ? 'card-locked' : '' }}" 
                 style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.03) !important;">
                
                @if($estado === 'aprobado' && $mensajesNuevos > 0)
                    <span class="position-absolute badge rounded-pill border border-2 border-white shadow-sm badge-pulse" 
                          style="top: 20px; right: 20px; background-color: #f53003; color: white; font-size: 0.85rem; padding: 6px 10px; z-index: 3;">
                        {{ __('comerciante.new_messages', ['count' => $mensajesNuevos]) }}
                    </span>
                @endif

                <div class="card-body p-4 d-flex flex-column align-items-start">
                    <div class="p-3 rounded-4 mb-4 d-inline-flex text-white shadow-sm" style="background: linear-gradient(135deg, #6a1b9a, #8e24aa); border-radius: 18px !important;">
                        <i class="bi bi-chat-square-text fs-3"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-2" style="letter-spacing: -0.5px;">{{ __('comerciante.card_forum_title') }}</h4>
                    <p class="text-secondary small flex-grow-1" style="line-height: 1.5;">{{ __('comerciante.card_forum_desc') }}</p>
                    
                    @if($estado === 'aprobado')
                        <a href="{{ route('foros.show', $user->negocio->id) }}" class="btn w-100 rounded-pill fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2 mt-3" 
                           style="background-color: #f3e5f5; color: #6a1b9a; border: none;">
                            {{ __('comerciante.card_forum_btn') }} <i class="bi bi-arrow-right small"></i>
                        </a>
                    @else
                        <button class="btn w-100 rounded-pill fw-bold py-2.5 border-0 mt-3" style="background-color: #e9ecef; color: #adb5bd;" disabled>
                            <i class="bi bi-lock-fill me-1 small"></i> {{ __('comerciante.btn_locked') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm transition-hover {{ $estado !== 'aprobado' ? 'card-locked' : '' }}" 
                 style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.03) !important;">
                <div class="card-body p-4 d-flex flex-column align-items-start">
                    <div class="p-3 rounded-4 mb-4 d-inline-flex text-white shadow-sm" style="background: linear-gradient(135deg, #f57c00, #ffb300); border-radius: 18px !important;">
                        <i class="bi bi-shop fs-3"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-2" style="letter-spacing: -0.5px;">{{ __('comerciante.card_business_title') }}</h4>
                    <p class="text-secondary small flex-grow-1" style="line-height: 1.5;">{{ __('comerciante.card_business_desc') }}</p>
                    
                    @if($estado === 'aprobado')
                        <a href="{{ route('comerciante.edit') }}" class="btn w-100 rounded-pill fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2 mt-3" 
                           style="background-color: #fff3e0; color: #e65100; border: none;">
                            {{ __('comerciante.card_business_btn') }} <i class="bi bi-arrow-right small"></i>
                        </a>
                    @else
                        <button class="btn w-100 rounded-pill fw-bold py-2.5 border-0 mt-3" style="background-color: #e9ecef; color: #adb5bd;" disabled>
                            <i class="bi bi-lock-fill me-1 small"></i> {{ __('comerciante.btn_locked') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.03) !important;">
                <div class="card-body p-4 d-flex flex-column align-items-start">
                    <div class="p-3 rounded-4 mb-4 d-inline-flex text-white shadow-sm" style="background: linear-gradient(135deg, #37474f, #546e7a); border-radius: 18px !important;">
                        <i class="bi bi-person-gear fs-3"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-2" style="letter-spacing: -0.5px;">{{ __('comerciante.card_account_title') }}</h4>
                    <p class="text-secondary small flex-grow-1" style="line-height: 1.5;">{{ __('comerciante.card_account_desc') }}</p>
                    <a href="{{ route('profile.edit') }}" class="btn w-100 rounded-pill fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2 mt-3" 
                       style="background-color: #eceff1; color: #37474f; border: none;">
                        {{ __('comerciante.card_account_btn') }} <i class="bi bi-arrow-right small"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease, opacity 0.3s ease;
    }
    .transition-hover:hover:not(.card-locked) {
        transform: translateY(-6px) !important;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
    }
    .card-locked {
        opacity: 0.65;
        cursor: not-allowed;
    }
    .opacity-90 { opacity: 0.9; }
    .opacity-10 { opacity: 0.1; }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    .badge-pulse {
        animation: pulse 2s infinite ease-in-out;
    }
</style>
@endsection