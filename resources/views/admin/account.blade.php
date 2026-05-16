@extends('layouts.layout')

@section('title', __('admin.page_title'))

@section('content')
<div class="container mt-5 pt-4 mb-5">
    
    <div class="card border-0 shadow-sm mb-5" style="border-radius: 24px; background: linear-gradient(135deg, #1b1b18 0%, #33332e 100%);">
        <div class="card-body p-4 p-md-5 d-flex flex-column flex-md-row align-items-center justify-content-between gap-4">
            <div class="d-flex flex-column flex-md-row align-items-center gap-4 text-center text-md-start">
                <div class="d-flex align-items-center justify-content-center rounded-circle shadow-inner bg-white" 
                     style="width: 75px; height: 75px; min-width: 75px;">
                    <span class="fs-2 fw-bold" style="color: #f53003;">{{ strtoupper(substr(Auth::user()->nombre ?? 'A', 0, 1)) }}</span>
                </div>
                <div>
                    <h2 class="fw-bolder text-white mb-1" style="letter-spacing: -1px;">{{ __('admin.main_heading') }}</h2>
                    <p class="text-white-50 mb-0 small">{!! __('admin.welcome_message', ['name' => '<span class="text-white fw-bold">' . Auth::user()->nombre . '</span>']) !!}</p>
                </div>
            </div>
            <span class="badge rounded-pill px-4 py-2 text-white bg-white bg-opacity-10 fw-bold border border-white border-opacity-10 align-self-center fs-7">
                <i class="bi bi-shield-check me-2 text-warning"></i>{{ __('admin.role_label') }}
            </span>
        </div>
    </div>

    <div class="row g-4">
        
        {{-- CARD: VALIDACIONES --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 admin-card" style="border-radius: 24px;">
                <div class="card-body p-4 p-lg-5 text-center d-flex flex-column justify-content-between">
                    <div>
                        <div class="icon-circle bg-warning bg-opacity-10 text-warning mb-4 mx-auto shadow-inner">
                            <i class="bi bi-shop fs-3"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">{{ __('admin.validations_title') }}</h4>
                        <p class="text-secondary small mb-4">
                            {!! __('admin.validations_desc', ['count' => '<strong class="text-warning fs-6">' . $totalPendientes . '</strong>']) !!}
                        </p>
                    </div>
                    <a href="{{ route('admin.validaciones') }}" class="btn w-100 py-3 text-white fw-bold shadow-sm btn-admin-action" 
                       style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 14px; border: none;">
                        <i class="bi bi-file-earmark-check me-2"></i> {{ __('admin.btn_review_now') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- CARD: USUARIOS --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 admin-card" style="border-radius: 24px;">
                <div class="card-body p-4 p-lg-5 text-center d-flex flex-column justify-content-between">
                    <div>
                        <div class="icon-circle bg-primary bg-opacity-10 text-primary mb-4 mx-auto shadow-inner">
                            <i class="bi bi-people fs-3"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">{{ __('admin.users_title') }}</h4>
                        <p class="text-secondary small mb-4">
                            {!! __('admin.users_desc', ['count' => '<strong class="text-primary fs-6">' . $totalUsuarios . '</strong>']) !!}
                        </p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn w-100 py-3 text-white fw-bold shadow-sm btn-admin-action" 
                       style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); border-radius: 14px; border: none;">
                        <i class="bi bi-search me-2"></i> {{ __('admin.btn_view_full_list') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- CARD: MODERACIÓN --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 admin-card" style="border-radius: 24px;">
                <div class="card-body p-4 p-lg-5 text-center d-flex flex-column justify-content-between">
                    <div>
                        <div class="icon-circle bg-danger bg-opacity-10 text-danger mb-4 mx-auto shadow-inner">
                            <i class="bi bi-exclamation-triangle fs-3"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">{{ __('admin.moderation_title') }}</h4>
                        <p class="text-secondary small mb-4">
                            {!! __('admin.moderation_desc', ['count' => '<strong class="text-danger fs-6">' . $totalDenuncias . '</strong>']) !!}
                        </p>
                    </div>
                    <button class="btn w-100 py-3 text-white fw-bold shadow-sm btn-disabled-custom" disabled 
                            style="border-radius: 14px; border: none;">
                        <i class="bi bi-shield-x me-2"></i> {{ __('admin.btn_view_reports') }}
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .admin-card {
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
    }
    .admin-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
    }

    .icon-circle {
        width: 75px;
        height: 75px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
    }

    .shadow-inner {
        box-shadow: inset 0 2px 6px rgba(0,0,0,0.04);
    }

    .btn-admin-action {
        transition: all 0.2s ease;
    }
    .btn-admin-action:hover {
        transform: scale(1.02);
        filter: brightness(1.05);
    }

    .btn-disabled-custom {
        background-color: #f1f1f0 !important;
        color: #a1a19f !important;
        cursor: not-allowed;
    }
</style>
@endsection