@extends('layouts.layout')

@section('title', __('foro.index_title'))

@section('content')
<div class="container mt-5 pt-4 mb-5">
    <div class="row mb-5">
        <div class="col-12">
            <div class="p-4 p-md-5 shadow-sm d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-4" 
                 style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%); border-radius: 24px; border: 1px solid rgba(0,0,0,0.05);">
                <div>
                    <span class="badge mb-1 text-white px-3 py-1 rounded-pill" style="background-color: #f53003; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">{{ __('foro.badge_community_short') }}</span>
                    <h1 class="fw-bolder text-dark mb-1" style="letter-spacing: -1px;">{{ __('foro.index_header_title') }}</h1>
                    <p class="text-secondary mb-0 fs-5">{{ __('foro.index_subtitle') }}</p>
                </div>
                <div>
                    <a href="{{ Auth::user()->rol === 'Cliente' ? route('cliente.account') : (Auth::user()->rol === 'Comerciante' ? route('comerciante.account') : route('admin.account')) }}"
                       class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm transition-hover bg-white">
                        <i class="bi bi-arrow-left me-2"></i>{{ __('foro.btn_back_dashboard') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($negocios as $negocio)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 border-0 shadow-sm transition-hover position-relative" 
                     style="border-radius: 24px; background-color: #ffffff; overflow: hidden; border: 1px solid rgba(0,0,0,0.03) !important;">
                    
                    <div class="position-relative" style="height: 140px; background-color: #f8f9fa;">
                        <img src="{{ $negocio->imagen ? asset('storage/' . $negocio->imagen) : 'https://via.placeholder.com/400x250?text=' . urlencode($negocio->nombre_negocio) }}"
                             class="w-100 h-100" alt="{{ $negocio->nombre_negocio }}"
                             style="object-fit: cover; filter: brightness(0.95);">
                        
                        <span class="position-absolute badge rounded-pill bg-white text-dark shadow-sm px-2 py-1" style="top: 15px; right: 15px; font-size: 0.7rem; font-weight: 700;">
                            <i class="bi bi-circle-fill text-success me-1" style="font-size: 0.5rem;"></i> {{ __('foro.status_active') }}
                        </span>
                    </div>

                    <div class="card-body p-4 d-flex flex-column text-center" style="margin-top: -30px;">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white shadow-sm p-1 mx-auto mb-3" style="width: 64px; height: 64px; z-index: 2;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-inner" 
                                 style="width: 100%; height: 100%; background-color: #f53003; font-size: 1.2rem;">
                                {{ strtoupper(substr($negocio->nombre_negocio, 0, 1)) }}
                            </div>
                        </div>

                        <h5 class="fw-bolder text-dark mb-2 text-truncate" style="letter-spacing: -0.3px;">{{ $negocio->nombre_negocio }}</h5>
                        
                        <p class="text-secondary small flex-grow-1 px-1 mb-4" style="line-height: 1.5;">
                            {{ $negocio->descripcion ? Str::limit($negocio->descripcion, 75) : __('foro.no_description') }}
                        </p>
                        
                        <a href="{{ route('foros.show', $negocio->id) }}" class="btn w-100 rounded-pill fw-bold py-2.5 transition-hover d-flex align-items-center justify-content-center gap-2"
                           style="background-color: #e8f3ee; color: #2e7d32; border: none; font-size: 0.95rem;">
                            <i class="bi bi-chat-square-text-fill" style="color: #f53003;"></i> {{ __('foro.btn_enter_forum') }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 bg-white shadow-sm mx-auto" style="border-radius: 24px; max-width: 500px; border: 1px solid rgba(0,0,0,0.05);">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 80px; height: 80px; background-color: #e8f3ee; color: #2e7d32;">
                        <i class="bi bi-shop-window fs-1"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-1">{{ __('foro.no_forums_available') }}</h4>
                    <p class="text-muted small mb-0">{{ __('foro.no_forums_available_helper') }}</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
    }

    .transition-hover:hover {
        transform: translateY(-6px) !important;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
    }
    
    .shadow-inner {
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
@endsection