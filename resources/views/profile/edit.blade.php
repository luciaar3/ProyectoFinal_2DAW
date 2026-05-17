@extends('layouts.layout')

@section('title', __('profile.page_title'))

@section('content')
<style>
    .shadow-inner { box-shadow: inset 0 2px 6px rgba(0,0,0,0.03); }
    .shadow-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(245, 48, 3, 0.05) !important;
    }
    .btn-guardar-cambios:hover {
        transform: scale(1.01);
        box-shadow: 0 8px 20px rgba(245, 48, 3, 0.25) !important;
    }
    .hover-link:hover { color: #f53003 !important; }
    .btn-volver:hover {
        background-color: #f8f9fa !important;
        color: #f53003 !important;
        transform: translateX(-2px);
        transition: all 0.2s ease;
    }
</style>
<div class="container mt-5 pt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 py-1" style="background: transparent;">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none fw-medium text-secondary hover-link">{{ __('profile.bc_home') }}</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route($user->rol === 'Comerciante' ? 'comerciante.account' : 'cliente.account') }}" class="text-decoration-none fw-medium text-secondary hover-link">
                                {{ __('profile.bc_account') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active fw-bold" aria-current="page" style="color: #f53003;">{{ __('profile.bc_settings') }}</li>
                    </ol>
                </nav>
            </div>

            <div class="card border-0 shadow-sm mb-4 shadow-hover" style="border-radius: 24px; transition: transform 0.3s ease;">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-5 position-relative">                   
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 shadow-inner" style="width: 80px; height: 80px; background-color: rgba(245, 48, 3, 0.08);">
                            <span class="fs-1 fw-bold" style="color: #f53003;">{{ substr($user->nombre, 0, 1) }}</span>
                        </div>
                        <h3 class="fw-bolder text-dark" style="letter-spacing: -1px;">{{ __('profile.title') }}</h3>
                        <p class="text-secondary small mb-0">
                            {{ __('profile.current_role') }} <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(245, 48, 3, 0.1); color: #f53003; font-weight: 600;">{{ __('profile.role_' . strtolower($user->rol)) ?? $user->rol }}</span>
                        </p>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="nombre" class="form-label text-secondary small fw-bold">{{ __('profile.label_name') }}</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $user->nombre) }}" required style="border-radius: 12px; border: 1px solid #eee; padding: 10px 15px;">
                                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="primer_apellido" class="form-label text-secondary small fw-bold">{{ __('profile.label_first_lastname') }}</label>
                                <input type="text" class="form-control @error('primer_apellido') is-invalid @enderror" id="primer_apellido" name="primer_apellido" value="{{ old('primer_apellido', $user->primer_apellido) }}" required style="border-radius: 12px; border: 1px solid #eee; padding: 10px 15px;">
                                @error('primer_apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="segundo_apellido" class="form-label text-secondary small fw-bold">{{ __('profile.label_second_lastname') }}</label>
                                <input type="text" class="form-control @error('segundo_apellido') is-invalid @enderror" id="segundo_apellido" name="segundo_apellido" value="{{ old('segundo_apellido', $user->segundo_apellido) }}" style="border-radius: 12px; border: 1px solid #eee; padding: 10px 15px;">
                                @error('segundo_apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label text-secondary small fw-bold">{{ __('profile.label_email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required style="border-radius: 12px; border: 1px solid #eee; padding: 10px 15px;">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr class="text-muted my-4 opacity-25">
                        <h6 class="fw-bold mb-3 text-dark d-flex align-items-center"><i class="bi bi-shield-lock me-2 text-secondary"></i>{{ __('profile.security_title') }}</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label text-secondary small">{{ __('profile.label_password') }} <span class="text-muted small">({{ __('profile.optional') }})</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" style="border-radius: 12px; border: 1px solid #eee; padding: 10px 15px;">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label text-secondary small">{{ __('profile.label_password_confirm') }}</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" style="border-radius: 12px; border: 1px solid #eee; padding: 10px 15px;">
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 py-3 text-white fw-bold shadow-sm mt-2 btn-guardar-cambios" style="background: linear-gradient(135deg, #f53003 0%, #ff6b4a 100%); border-radius: 14px; border: none; transition: all 0.3s ease;">
                            <i class="bi bi-save me-2"></i> {{ __('profile.save_btn') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm border-start border-4 border-danger" style="border-radius: 24px; background-color: #fffcfc;">
                <div class="card-body p-4 p-md-5 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                    <div>
                        <h5 class="fw-bold text-danger mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ __('profile.danger_title') }}</h5>
                        <p class="text-secondary small mb-0" style="max-width: 450px;">{{ __('profile.danger_desc') }}</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-danger fw-bold rounded-pill px-4 py-2 small" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            {{ __('profile.delete_btn') }}
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="deleteAccountModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 28px; overflow: hidden;">
            <div class="modal-body p-4 p-md-5 text-center">
                <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle mb-4" style="width: 70px; height: 70px;">
                    <i class="bi bi-trash3-fill fs-2"></i>
                </div>
                <h4 class="fw-bolder text-dark mb-2">{{ __('profile.modal_title') }}</h4>
                <p class="text-secondary small mb-4 px-lg-3">
                    {{ __('profile.modal_desc') }}
                </p>
                
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold py-2 w-50" data-bs-dismiss="modal">
                            {{ __('profile.modal_cancel') }}
                        </button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold py-2 w-50 shadow-sm">
                            {{ __('profile.modal_confirm') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection