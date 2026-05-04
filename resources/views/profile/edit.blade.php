@extends('layouts.layout')

@section('title', 'Mi Perfil - Market Manager')

@section('content')
<div class="container mt-5 pt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert" style="background-color: #e6f8f3; border-color: #b0eed3; color: #0f5132;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm" style="border-radius: 24px;">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 80px; height: 80px;">
                            <span class="fs-1 fw-bold" style="color: #7b52d9;">{{ substr($user->nombre, 0, 1) }}</span>
                        </div>
                        <h3 class="fw-bolder text-dark">Mis Datos Personales</h3>
                        <p class="text-secondary small">
                            Rol actual: <span class="badge rounded-pill" style="background-color: rgba(123, 82, 217, 0.1); color: #7b52d9;">{{ $user->rol ?? 'Usuario' }}</span>
                        </p>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="nombre" class="form-label text-secondary">Nombre</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $user->nombre) }}" required style="border-radius: 12px;">
                                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="primer_apellido" class="form-label text-secondary">Primer Apellido</label>
                                <input type="text" class="form-control @error('primer_apellido') is-invalid @enderror" id="primer_apellido" name="primer_apellido" value="{{ old('primer_apellido', $user->primer_apellido) }}" required style="border-radius: 12px;">
                                @error('primer_apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="segundo_apellido" class="form-label text-secondary">Segundo Apellido</label>
                                <input type="text" class="form-control @error('segundo_apellido') is-invalid @enderror" id="segundo_apellido" name="segundo_apellido" value="{{ old('segundo_apellido', $user->segundo_apellido) }}" style="border-radius: 12px;">
                                @error('segundo_apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label text-secondary">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required style="border-radius: 12px;">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr class="text-muted my-4">
                        <h6 class="fw-bold mb-3 text-dark">Cambiar Contraseña <span class="text-secondary fw-normal fs-6">(dejar en blanco si no quieres cambiarla)</span></h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label text-secondary">Nueva Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" style="border-radius: 12px;">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label text-secondary">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" style="border-radius: 12px;">
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 py-3 text-white fw-bold shadow-sm mt-2" style="background-color: #7b52d9; border-radius: 12px; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                            Guardar Cambios
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
