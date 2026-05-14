@extends('layouts.layout') 
@section('title', 'Únete a MercaZone - Registro')

@section('content')
<style>
    /* --- FONDO COHERENTE --- */
    body {
        background-color: #f4f4f7;
        background-image: 
            linear-gradient(to bottom, rgba(255, 255, 255, 0.8) 0%, rgba(244, 244, 247, 0.9) 100%),
            url('https://images.unsplash.com/photo-1533900298318-6b8da08a523e?q=80&w=1920&auto=format&fit=crop&blur=50'); 
        background-attachment: fixed;
        background-size: cover;
        min-height: 100vh;
    }

    /* --- TARJETA DE REGISTRO (SIN HISTORIA) --- */
    .register-container {
        padding-top: 5rem;
        padding-bottom: 5rem;
    }

    .register-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 32px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 25px 50px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .register-header {
        background: white;
        padding: 2.5rem 2rem 1.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(0,0,0,0.1);
        background: rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #f53003;
        box-shadow: 0 0 0 4px rgba(245, 48, 3, 0.1);
        background: white;
    }

    .form-label {
        font-weight: 600;
        color: #444;
        margin-left: 5px;
        font-size: 0.9rem;
    }

    .btn-mercazone {
        background: #f53003;
        color: white;
        border-radius: 50px;
        padding: 12px;
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

    #campos-comerciante {
        background: rgba(245, 48, 3, 0.03);
        border-radius: 20px;
        padding: 20px;
        border: 1px dashed rgba(245, 48, 3, 0.2);
        margin-top: 20px;
    }
</style>

<div class="container register-container">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="register-card">
                
                <div class="register-header">
                    <h2 class="fw-bolder text-dark mb-1" style="letter-spacing: -1.5px;">
                        Merca<span class="text-mercazone">Zone</span>
                    </h2>
                    <p class="text-secondary">Crea tu cuenta en un minuto y empieza a mover tu barrio.</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('registro.post') }}">
                        @csrf

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" placeholder="Tu nombre" required>
                                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="primer_apellido" class="form-label">Primer Apellido</label>
                                <input type="text" name="primer_apellido" id="primer_apellido" class="form-control @error('primer_apellido') is-invalid @enderror" value="{{ old('primer_apellido') }}" placeholder="1er Apellido" required>
                                @error('primer_apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                                <input type="text" name="segundo_apellido" id="segundo_apellido" class="form-control @error('segundo_apellido') is-invalid @enderror" value="{{ old('segundo_apellido') }}" placeholder="2º Apellido (opcional)">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="ejemplo@correo.com" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="rol" class="form-label">¿Qué buscas en MercaZone?</label>
                            <select name="rol" id="rol" class="form-select @error('rol') is-invalid @enderror" required style="border-left: 5px solid #f53003;">
                                <option value="" selected disabled>Elige tu perfil...</option>
                                <option value="Cliente" {{ old('rol') == 'Cliente' ? 'selected' : '' }}>Cliente (Quiero comprar)</option>
                                <option value="Comerciante" {{ old('rol') == 'Comerciante' ? 'selected' : '' }}>Comerciante (Tengo un puesto)</option>
                            </select>
                            @error('rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div id="campos-comerciante" style="display: {{ old('rol') == 'Comerciante' ? 'block' : 'none' }};">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-mercazone p-2 rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-shop text-white"></i>
                                </div>
                                <h5 class="mb-0 fw-bold text-dark">Datos del Comercio</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre del Negocio</label>
                                    <input type="text" name="nombre_negocio" class="form-control @error('nombre_negocio') is-invalid @enderror" value="{{ old('nombre_negocio') }}" placeholder="Ej: Frutas Paco">
                                    @error('nombre_negocio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">NIF / DNI</label>
                                    <input type="text" name="nif" class="form-control @error('nif') is-invalid @enderror" value="{{ old('nif') }}" placeholder="12345678X">
                                    @error('nif') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Número de Permiso</label>
                                    <input type="number" name="numero_permiso" class="form-control @error('numero_permiso') is-invalid @enderror" value="{{ old('numero_permiso') }}" placeholder="Nº Licencia">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" placeholder="600000000">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Breve descripción</label>
                                    <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="2" placeholder="¿Qué vendes?">{{ old('descripcion') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-mercazone btn-lg">
                                Registrar mi cuenta <i class="bi bi-check-circle ms-2"></i>
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-secondary">¿Ya eres parte de la familia? <a href="{{ route('login') }}" class="text-mercazone text-decoration-none fw-bold">Inicia sesión aquí</a></p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/" class="text-secondary text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la página principal
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('rol').addEventListener('change', function() {
        const camposExtra = document.getElementById('campos-comerciante');
        if (this.value === 'Comerciante') {
            camposExtra.style.display = 'block';
        } else {
            camposExtra.style.display = 'none';
        }
    });
</script>
@endsection