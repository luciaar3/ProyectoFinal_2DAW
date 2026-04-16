@extends('layouts.layout')

@section('title', 'Iniciar Sesión - Market Manager')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow border-0 mt-5">
            <div class="card-header bg-dark text-white text-center py-3">
                <h4 class="mb-0">Iniciar Sesión</h4>
            </div>
            <div class="card-body p-4">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark btn-lg">Entrar a mi panel</button>
                    </div>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0">¿No tienes cuenta? <a href="{{ route('registro') }}" class="text-primary fw-bold text-decoration-none">Regístrate aquí</a></p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection