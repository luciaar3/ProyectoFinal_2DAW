@extends('layouts.layout')

@section('title', 'Editar mi Negocio')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h4 class="mb-4 fw-bold text-primary">Configuración del Negocio</h4>
                    
                    <form action="{{ route('comerciante.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre Comercial</label>
                            <input type="text" name="nombre" id="inputNombre" class="form-control rounded-pill @error('nombre') is-invalid @enderror" 
                                value="{{ old('nombre', $negocio->nombre) }}" placeholder="Ej. Frutas Mari">
                            @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">NIF</label>
                                <input type="text" name="nif" class="form-control rounded-pill" value="{{ old('nif', $negocio->nif) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Teléfono</label>
                                <input type="text" name="telefono" id="inputTelefono" class="form-control rounded-pill" value="{{ old('telefono', $negocio->telefono) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Número de Permiso Municipal</label>
                            <input type="number" name="numero_permiso" class="form-control rounded-pill" value="{{ old('numero_permiso', $negocio->numero_permiso) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción para Clientes</label>
                            <textarea name="descripcion" id="inputDesc" class="form-control" style="border-radius: 15px;" rows="4">{{ old('descripcion', $negocio->descripcion) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Logo</label>
                            <input type="file" name="imagen" class="form-control rounded-pill shadow-sm">
                            <small class="text-muted">Se recomienda una foto clara de tu puesto o logo.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Fotos de la Galería</label>
                            <input type="file" name="fotos_galeria[]" class="form-control rounded-pill" multiple>
                            <div class="form-text">Puedes seleccionar varias fotos de tu puesto a la vez.</div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($negocio->imagenes as $img)
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $img->ruta) }}" class="rounded shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                            @endforeach
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow">
                                <i class="fas fa-save me-2"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="sticky-top" style="top: 20px;">
                <h5 class="text-secondary mb-3 ms-2">Vista previa para clientes</h5>
                
                <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 25px;">
                    <div class="position-relative">
                        @if($negocio->imagen)
                            <img src="{{ asset('storage/' . $negocio->imagen) }}" class="w-100" style="height: 200px; object-fit: cover;" alt="Negocio">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-store fa-4x text-muted"></i>
                            </div>
                        @endif
                        <span class="position-absolute top-0 start-0 m-3 badge rounded-pill bg-success">Abierto ahora</span>
                    </div>
                    
                    <div class="card-body p-4 text-center">
                        <h3 class="fw-bold mb-1" id="previewNombre">{{ $negocio->nombre }}</h3>
                        <p class="text-muted small mb-3">
                            <i class="fas fa-phone me-1"></i> <span id="previewTelefono">{{ $negocio->telefono }}</span>
                        </p>
                        
                        <p class="card-text text-secondary mb-4" id="previewDesc">
                            {{ Str::limit($negocio->descripcion, 120) }}
                        </p>
                        
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary rounded-pill disabled">Ver Productos</button>
                            <button class="btn btn-light rounded-pill disabled">Ver Ruta Semanal</button>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-white border-0 py-3 text-center">
                        <small class="text-primary fw-bold">Market Manager Verified <i class="fas fa-check-circle"></i></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const inputNombre = document.getElementById('inputNombre');
    const previewNombre = document.getElementById('previewNombre');
    const inputTelefono = document.getElementById('inputTelefono');
    const previewTelefono = document.getElementById('previewTelefono');
    const inputDesc = document.getElementById('inputDesc');
    const previewDesc = document.getElementById('previewDesc');

    inputNombre.addEventListener('input', () => previewNombre.innerText = inputNombre.value || 'Nombre del Negocio');
    inputTelefono.addEventListener('input', () => previewTelefono.innerText = inputTelefono.value || '000 000 000');
    inputDesc.addEventListener('input', () => {
        let text = inputDesc.value;
        previewDesc.innerText = text.length > 120 ? text.substring(0, 120) + '...' : text || 'Tu descripción aparecerá aquí...';
    });
</script>
@endsection