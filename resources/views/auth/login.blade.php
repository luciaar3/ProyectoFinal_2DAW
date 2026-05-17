@extends('layouts.layout')

@section('title', __('login.page_title'))

@section('content')
<style>
    body {
        background-color: #f4f4f7;
        background-image: 
            linear-gradient(to bottom, rgba(255, 255, 255, 0.8) 0%, rgba(244, 244, 247, 0.9) 100%),
            url('https://images.unsplash.com/photo-1533900298318-6b8da08a523e?q=80&w=1920&auto=format&fit=crop&blur=50'); 
        background-attachment: fixed;
        background-size: cover;
        min-height: 100vh;
    }

    /* --- TARJETA LOGIN --- */
    .login-container {
        padding-top: 6rem;
        padding-bottom: 6rem;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 32px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 25px 50px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .login-header {
        background: white;
        padding: 3rem 2rem 2rem;
        text-align: center;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .login-icon {
        width: 70px;
        height: 70px;
        background: #f53003;
        color: white;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 20px rgba(245, 48, 3, 0.2);
    }

    /* --- INPUTS --- */
    .form-control {
        border-radius: 12px;
        padding: 0.85rem 1.2rem;
        border: 1px solid rgba(0,0,0,0.1);
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #f53003;
        box-shadow: 0 0 0 4px rgba(245, 48, 3, 0.1);
    }

    .form-label {
        font-weight: 600;
        color: #444;
        margin-left: 5px;
        font-size: 0.9rem;
    }

    /* --- BOTÓN --- */
    .btn-mercazone {
        background: #f53003;
        color: white;
        border-radius: 50px;
        padding: 14px;
        font-weight: bold;
        font-size: 1.1rem;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(245, 48, 3, 0.2);
    }

    .btn-mercazone:hover {
        background: #d42902;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(245, 48, 3, 0.3);
        color: white;
    }

    .text-mercazone { color: #f53003; }
</style>

<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            
            <div class="login-card">
                <div class="login-header">
                    <div class="login-icon">
                        <i class="bi bi-person-lock"></i>
                    </div>
                    <h2 class="fw-bolder text-dark mb-1" style="letter-spacing: -1px;">
                        Merca<span class="text-mercazone">Zone</span>
                    </h2>
                    <p class="text-secondary small">{{ __('login.welcome_back') }}</p>
                </div>

                <div class="card-body p-4 p-md-5">

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('login.label_email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="{{ __('login.placeholder_email') }}" required autofocus>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label">{{ __('login.label_password') }}</label>
                            </div>
                            
                            <div class="position-relative">
                                <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror" 
                                    id="password" name="password" placeholder="••••••••" required>
                                
                                <button type="button" id="togglePassword" class="btn position-absolute end-0 top-50 translate-middle-y border-0 text-secondary me-2" style="z-index: 10;">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-mercazone">
                                {{ __('login.btn_submit') }} <i class="bi bi-box-arrow-in-right ms-2"></i>
                            </button>
                        </div>
                        
                        <div class="text-center mt-4">
                            <p class="mb-0 text-secondary">{{ __('login.no_account') }} 
                                <a href="{{ route('registro') }}" class="text-mercazone fw-bold text-decoration-none">{{ __('login.register_here') }}</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/" class="text-secondary text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i> {{ __('login.back_to_home') }}
                </a>
            </div>

        </div>
    </div>
</div>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye');
        }
    });
</script>
@endsection