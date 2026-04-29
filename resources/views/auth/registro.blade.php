@extends('layouts.layout') 
@section('title', 'Registro - Market Manager')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0 mt-5">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0">Crea tu cuenta en Market Manager</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('registro.post') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="primer_apellido" class="form-label">Primer Apellido</label>
                            <input type="text" name="primer_apellido" id="primer_apellido" class="form-control @error('primer_apellido') is-invalid @enderror" value="{{ old('primer_apellido') }}" required>
                            @error('primer_apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                            <input type="text" name="segundo_apellido" id="segundo_apellido" class="form-control @error('segundo_apellido') is-invalid @enderror" value="{{ old('segundo_apellido') }}">
                            @error('segundo_apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="rol" class="form-label">Quiero registrarme como:</label>
                        <select name="rol" id="rol" class="form-select @error('rol') is-invalid @enderror" required>
                            <option value="" selected disabled>Selecciona una opción...</option>
                            <option value="Cliente" {{ old('rol') == 'Cliente' ? 'selected' : '' }}>Cliente (Quiero comprar)</option>
                            <option value="Comerciante" {{ old('rol') == 'Comerciante' ? 'selected' : '' }}>Comerciante (Quiero vender)</option>
                        </select>
                        @error('rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div id="campos-comerciante" style="display: {{ old('rol') == 'Comerciante' ? 'block' : 'none' }};">
                        <hr>
                        <h5 class="text-primary mb-3">Datos del Comercio</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre del Negocio</label>
                                <input type="text" name="nombre_negocio" class="form-control @error('nombre_negocio') is-invalid @enderror" value="{{ old('nombre_negocio') }}">
                                @error('nombre_negocio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIF / DNI</label>
                                <input type="text" name="nif" class="form-control @error('nif') is-invalid @enderror" placeholder="Ej: 12345678X" value="{{ old('nif') }}">
                                @error('nif') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Número de Permiso</label>
                                <input type="number" name="numero_permiso" class="form-control @error('numero_permiso') is-invalid @enderror" placeholder="Nº de licencia" value="{{ old('numero_permiso') }}">
                                @error('numero_permiso') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono de contacto</label>
                                <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" 
                                    inputmode="numeric" pattern="[0-9]*" placeholder="Ej: 600123456" 
                                    value="{{ old('telefono') }}">
                                @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Descripción del Negocio</label>
                                <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" placeholder="Cuéntanos qué vendes...">{{ old('descripcion') }}</textarea>
                                @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Registrar cuenta</button>
                    </div>

                    <div class="text-center mt-3">
                        <p class="mb-0">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">Inicia sesión</a></p>
                    </div>
                </form>
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