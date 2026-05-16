@extends('layouts.layout')

@section('title', __('dashboard.page_title'))

@section('content')
<div class="container mt-5 pt-4 mb-5">
    
    <div class="row mb-5">
        <div class="col-12">
            <div class="p-4 p-md-5 shadow-sm d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4 position-relative overflow-hidden text-white" 
                 style="background: linear-gradient(135deg, #f53003 0%, #ff6b4a 100%); border-radius: 24px;">
                
                <div class="position-absolute opacity-10" style="right: -20px; bottom: -30px; font-size: 12rem; line-height: 1;">
                    <i class="bi bi-person-circle"></i>
                </div>

                <div class="position-relative" style="z-index: 2;">
                    <span class="badge bg-white text-dark mb-2 px-3 py-1 rounded-pill fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        {{ __('dashboard.badge') }}
                    </span>
                    <h1 class="fw-bolder mb-1" style="letter-spacing: -1px;">
                        {{ __('dashboard.hello', ['name' => Auth::user()->nombre]) }}
                    </h1>
                    <p class="mb-0 opacity-90 fs-5">{{ __('dashboard.welcome_message') }}</p>
                </div>

                <div class="position-relative" style="z-index: 2;">
                    <span class="btn btn-light rounded-pill px-4 fw-bold shadow-sm border-0 bg-white text-dark d-inline-flex align-items-center gap-2" style="pointer-events: none;">
                        <i class="bi bi-shield-check text-success fs-5"></i> {{ __('dashboard.secure_session') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.03) !important;">
                <div class="card-body p-4 d-flex flex-column align-items-start">
                    <div class="p-3 rounded-4 mb-4 d-inline-flex text-white shadow-sm" style="background: linear-gradient(135deg, #2e7d32, #43a047); border-radius: 18px !important;">
                        <i class="bi bi-shop fs-3"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-2" style="letter-spacing: -0.5px;">{{ __('dashboard.shops_title') }}</h4>
                    <p class="text-secondary small flex-grow-1" style="line-height: 1.5;">{{ __('dashboard.shops_desc') }}</p>
                    <a href="{{ route('negocios.index') }}" class="btn w-100 rounded-pill fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2 mt-3" 
                       style="background-color: #e8f3ee; color: #2e7d32; border: none;">
                        {{ __('dashboard.shops_btn') }} <i class="bi bi-arrow-right small"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.03) !important;">
                <div class="card-body p-4 d-flex flex-column align-items-start">
                    <div class="p-3 rounded-4 mb-4 d-inline-flex text-white shadow-sm" style="background: linear-gradient(135deg, #0288d1, #039be5); border-radius: 18px !important;">
                        <i class="bi bi-calendar-check fs-3"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-2" style="letter-spacing: -0.5px;">{{ __('dashboard.bookings_title') }}</h4>
                    <p class="text-secondary small flex-grow-1" style="line-height: 1.5;">{{ __('dashboard.bookings_desc') }}</p>
                    <a href="{{ route('cliente.reservas') }}" class="btn w-100 rounded-pill fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2 mt-3" 
                       style="background-color: #e1f5fe; color: #0288d1; border: none;">
                        {{ __('dashboard.bookings_btn') }} <i class="bi bi-arrow-right small"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.03) !important;">
                <div class="card-body p-4 d-flex flex-column align-items-start">
                    <div class="p-3 rounded-4 mb-4 d-inline-flex text-white shadow-sm" style="background: linear-gradient(135deg, #c62828, #e53935); border-radius: 18px !important;">
                        <i class="bi bi-heart fs-3"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-2" style="letter-spacing: -0.5px;">{{ __('dashboard.favorites_title') }}</h4>
                    <p class="text-secondary small flex-grow-1" style="line-height: 1.5;">{{ __('dashboard.favorites_desc') }}</p>
                    <a href="{{ route('cliente.favoritos') }}" class="btn w-100 rounded-pill fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2 mt-3" 
                       style="background-color: #ffebee; color: #c62828; border: none;">
                        {{ __('dashboard.favorites_btn') }} <i class="bi bi-arrow-right small"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.03) !important;">
                <div class="card-body p-4 d-flex flex-column align-items-start">
                    <div class="p-3 rounded-4 mb-4 d-inline-flex text-white shadow-sm" style="background: linear-gradient(135deg, #6a1b9a, #8e24aa); border-radius: 18px !important;">
                        <i class="bi bi-chat-square-text fs-3"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-2" style="letter-spacing: -0.5px;">{{ __('dashboard.forums_title') }}</h4>
                    <p class="text-secondary small flex-grow-1" style="line-height: 1.5;">{{ __('dashboard.forums_desc') }}</p>
                    <a href="{{ route('foros.index') }}" class="btn w-100 rounded-pill fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2 mt-3" 
                       style="background-color: #f3e5f5; color: #6a1b9a; border: none;">
                        {{ __('dashboard.forums_btn') }} <i class="bi bi-arrow-right small"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.03) !important;">
                <div class="card-body p-4 d-flex flex-column align-items-start">
                    <div class="p-3 rounded-4 mb-4 d-inline-flex text-white shadow-sm" style="background: linear-gradient(135deg, #37474f, #546e7a); border-radius: 18px !important;">
                        <i class="bi bi-gear fs-3"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-2" style="letter-spacing: -0.5px;">{{ __('dashboard.settings_title') }}</h4>
                    <p class="text-secondary small flex-grow-1" style="line-height: 1.5;">{{ __('dashboard.settings_desc') }}</p>
                    <a href="{{ route('profile.edit') }}" class="btn w-100 rounded-pill fw-bold py-2.5 d-flex align-items-center justify-content-center gap-2 mt-3" 
                       style="background-color: #eceff1; color: #37474f; border: none;">
                        {{ __('dashboard.settings_btn') }} <i class="bi bi-arrow-right small"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-6px) !important;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
    }
    .opacity-90 { opacity: 0.9; }
    .opacity-10 { opacity: 0.1; }
</style>
@endsection