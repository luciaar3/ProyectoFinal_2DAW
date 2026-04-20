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
                            <input type="text" name="nombre" id="inputNombre" 
                                class="form-control rounded-pill @error('nombre') is-invalid @enderror" 
                                value="{{ old('nombre', $negocio->nombre) }}">
                            @error('nombre')
                                <div class="invalid-feedback ms-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">NIF</label>
                                <input type="text" name="nif" 
                                    class="form-control rounded-pill @error('nif') is-invalid @enderror" 
                                    value="{{ old('nif', $negocio->nif) }}">
                                @error('nif')
                                    <div class="invalid-feedback ms-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Número de Permiso</label>
                                <input type="text" name="numero_permiso" 
                                    class="form-control rounded-pill bg-light" 
                                    value="{{ $negocio->numero_permiso }}" 
                                    readonly>
                                <div class="form-text ms-2">Este número está vinculado a tu licencia y no se puede cambiar.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Teléfono</label>
                                <input type="text" name="telefono" id="inputTelefono" 
                                    class="form-control rounded-pill @error('telefono') is-invalid @enderror" 
                                    value="{{ old('telefono', $negocio->telefono) }}">
                                @error('telefono')
                                    <div class="invalid-feedback ms-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción para Clientes</label>
                            <textarea name="descripcion" id="inputDesc" 
                                class="form-control @error('descripcion') is-invalid @enderror" 
                                style="border-radius: 15px;" rows="4">{{ old('descripcion', $negocio->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback ms-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Logo Principal</label>
                            <input type="file" name="imagen" 
                                class="form-control rounded-pill shadow-sm @error('imagen') is-invalid @enderror">
                            @error('imagen')
                                <div class="invalid-feedback ms-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Añadir Fotos a la Galería</label>
                            <input type="file" name="imagenes_galeria[]" id="inputGaleria" 
                                class="form-control rounded-pill @error('imagenes_galeria*') is-invalid @enderror" multiple>
                            <div class="form-text">Puedes seleccionar varias fotos a la vez.</div>
                            @error('imagenes_galeria*')
                                <div class="text-danger small ms-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <h6 class="fw-bold mb-3">Tu Galería actual:</h6>
                        <div class="d-flex flex-wrap gap-3 mb-4">
                            @foreach($negocio->imagenes as $img)
                                <div class="position-relative shadow-sm rounded" style="width: 100px; height: 100px;">
                                    <img src="{{ asset('storage/' . $img->ruta) }}" 
                                        class="rounded w-100 h-100" 
                                        style="object-fit: cover;">
                                    
                                    <button type="button" 
                                            onclick="confirmDelete('{{ route('comerciante.imagen.destroy', $img->id) }}')" 
                                            class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 24px; height: 24px; padding: 0; border: 2px solid white;"
                                            title="Eliminar foto">
                                        <i class="fas fa-times" style="font-size: 0.7rem;"></i>
                                    </button>
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
            </div>
    </div>
</div>

        <div class="col-lg-5">
            <div class="sticky-top" style="top: 20px;">
                <h5 class="text-secondary mb-3 ms-2">Vista previa para clientes</h5>
                
                <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 25px;">
                    <div class="position-relative">
                        <div id="previewCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" id="carouselInner">
                                @forelse($negocio->imagenes as $key => $img)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $img->ruta) }}" class="d-block w-100" style="height: 220px; object-fit: cover; filter: brightness(0.7);">
                                    </div>
                                @empty
                                    <div class="carousel-item active">
                                        <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 220px;">
                                            <i class="fas fa-images fa-3x text-white-50"></i>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="position-absolute start-50 translate-middle" style="top: 220px; z-index: 10;">
                            <div class="rounded-circle border border-4 border-white shadow" style="width: 100px; height: 100px; overflow: hidden; background: white;">
                                <img src="{{ $negocio->imagen ? asset('storage/' . $negocio->imagen) : '' }}" id="previewLogo" class="w-100 h-100 {{ $negocio->imagen ? '' : 'd-none' }}" style="object-fit: cover;">
                                <div id="logoPlaceholder" class="h-100 d-flex align-items-center justify-content-center bg-light {{ $negocio->imagen ? 'd-none' : '' }}">
                                    <i class="fas fa-store text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 55px;"></div>
                    <div class="card-body p-4 text-center">
                        <h3 class="fw-bold mb-1" id="previewNombre">{{ $negocio->nombre }}</h3>
                        <p class="text-muted small mb-3">
                            <i class="fas fa-phone me-1"></i> <span id="previewTelefono">{{ $negocio->telefono }}</span>
                        </p>
                        <p class="card-text text-secondary mb-4" id="previewDesc">
                            {{ Str::limit($negocio->descripcion, 120) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="delete-image-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    // 1. variables
    const inputNombre = document.getElementById('inputNombre');
    const previewNombre = document.getElementById('previewNombre');
    const inputTelefono = document.getElementById('inputTelefono');
    const previewTelefono = document.getElementById('previewTelefono');
    const inputDesc = document.getElementById('inputDesc');
    const previewDesc = document.getElementById('previewDesc');

    // 2. Sincronización de textos
    if(inputNombre) {
        inputNombre.addEventListener('input', () => previewNombre.innerText = inputNombre.value || 'Nombre del Negocio');
    }
    if(inputTelefono) {
        inputTelefono.addEventListener('input', () => previewTelefono.innerText = inputTelefono.value || '000 000 000');
    }
    if(inputDesc) {
        inputDesc.addEventListener('input', () => {
            let text = inputDesc.value;
            previewDesc.innerText = text.length > 120 ? text.substring(0, 120) + '...' : text || 'Tu descripción aquí...';
        });
    }

    // 3. Previsualizar Logo
    const inputImagen = document.querySelector('input[name="imagen"]');
    if(inputImagen) {
        inputImagen.addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const logo = document.getElementById('previewLogo');
                logo.src = e.target.result;
                logo.classList.remove('d-none');
                document.getElementById('logoPlaceholder').classList.add('d-none');
            }
            reader.readAsDataURL(this.files[0]);
        });
    }

    // 4. Función para borrar imagen
    function confirmDelete(url) {
        if(confirm('¿Estás seguro de que quieres eliminar esta foto de la galería?')) {
            const form = document.getElementById('delete-image-form');
            form.action = url; 
            form.submit();
        }
    }
</script>
@endsection