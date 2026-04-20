@extends('layouts.layout')

@section('title', 'Editar mi Negocio - ' . $negocio->nombre)

@section('content')
<style>
    .transition { transition: all 0.3s ease; }
    .hover-shadow:hover { 
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.08)!important;
        border-color: #0d6efd !important;
    }
    /* Estilo para inputs readonly */
    input[readonly] {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
</style>

<div class="container py-5">
    {{-- Formulario único para todo el panel --}}
    <form action="{{ route('comerciante.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h4 class="mb-4 fw-bold text-primary">Configuración del Negocio</h4>
                        
                        {{-- Nombre --}}
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
                            {{-- NIF --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">NIF</label>
                                <input type="text" name="nif" 
                                    class="form-control rounded-pill @error('nif') is-invalid @enderror" 
                                    value="{{ old('nif', $negocio->nif) }}">
                                @error('nif')
                                    <div class="invalid-feedback ms-2">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Teléfono --}}
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

                        {{-- Permiso (Solo lectura) --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Número de Permiso Municipal (No editable)</label>
                            <input type="text" name="numero_permiso" 
                                class="form-control rounded-pill" 
                                value="{{ $negocio->numero_permiso }}" 
                                readonly>
                            <div class="form-text ms-2 small">Este número está vinculado a tu licencia y no se puede cambiar.</div>
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción para Clientes</label>
                            <textarea name="descripcion" id="inputDesc" 
                                class="form-control @error('descripcion') is-invalid @enderror" 
                                style="border-radius: 15px;" rows="4">{{ old('descripcion', $negocio->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback ms-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Logo --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Logo Principal</label>
                            <input type="file" name="imagen" 
                                class="form-control rounded-pill shadow-sm @error('imagen') is-invalid @enderror">
                            @error('imagen')
                                <div class="invalid-feedback ms-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Galería --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Añadir Fotos a la Galería</label>
                            <input type="file" name="imagenes_galeria[]" id="inputGaleria" 
                                class="form-control rounded-pill @error('imagenes_galeria*') is-invalid @enderror" multiple>
                            <div class="form-text ms-2 small">Puedes seleccionar varias fotos a la vez.</div>
                            @error('imagenes_galeria*')
                                <div class="text-danger small ms-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Galería Actual --}}
                        <h6 class="fw-bold mb-3">Tu Galería actual:</h6>
                        <div class="d-flex flex-wrap gap-3 mb-4">
                            @foreach($negocio->imagenes as $img)
                                <div class="position-relative shadow-sm rounded" style="width: 80px; height: 80px;">
                                    <img src="{{ asset('storage/' . $img->ruta) }}" 
                                        class="rounded w-100 h-100" 
                                        style="object-fit: cover;">
                                    
                                    <button type="button" 
                                            onclick="confirmDelete('{{ route('comerciante.imagen.destroy', $img->id) }}')" 
                                            class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle rounded-circle p-0 d-flex align-items-center justify-content-center"
                                            style="width: 20px; height: 20px; border: 2px solid white;"
                                            title="Eliminar foto">
                                        <i class="fas fa-times" style="font-size: 0.6rem;"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN DE HORARIOS Y RUTA (Dentro del Form) --}}
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                <i class="fas fa-route"></i>
                            </div>
                            <h4 class="mb-0 fw-bold text-primary">Calendario de Ruta Semanal</h4>
                        </div>

                        <p class="text-muted small mb-4">Indica dónde se ubica tu puesto cada día. Usa el mapa para fijar la posición exacta y autocompletar la dirección.</p>

                        <div class="row g-2 timeline">
                            @foreach(['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'] as $dia)
                                @php
                                    // Buscamos el horario para este día
                                    $h = $negocio->horarios->where('dia', $dia)->first();
                                @endphp
                                <div class="col-12 p-3 rounded-4 border border-light-subtle shadow-sm bg-white hover-shadow transition mb-2">
                                    <div class="row align-items-center g-3">
                                        {{-- Día --}}
                                        <div class="col-md-2 fw-bold text-capitalize text-primary small">{{ $dia }}</div>

                                        {{-- Ubicación --}}
                                        <div class="col-md-5">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <input type="text" name="horarios[{{ $dia }}][poblacion]" 
                                                           id="pob-{{ $dia }}" {{-- ID para autocompletar --}}
                                                           class="form-control form-control-sm rounded-pill" 
                                                           placeholder="Población" 
                                                           value="{{ old("horarios.$dia.poblacion", $h->poblacion ?? '') }}">
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" name="horarios[{{ $dia }}][ubicacion]" 
                                                           id="ubi-{{ $dia }}" {{-- ID para autocompletar --}}
                                                           class="form-control form-control-sm rounded-pill" 
                                                           placeholder="Ubicación o Mercadillo" 
                                                           value="{{ old("horarios.$dia.ubicacion", $h->ubicacion ?? '') }}">
                                                </div>
                                            </div>
                                            {{-- Campos ocultos para coordenadas --}}
                                            <input type="hidden" name="horarios[{{ $dia }}][latitud]" id="lat-{{ $dia }}" value="{{ old("horarios.$dia.latitud", $h->latitud ?? '') }}">
                                            <input type="hidden" name="horarios[{{ $dia }}][longitud]" id="lng-{{ $dia }}" value="{{ old("horarios.$dia.longitud", $h->longitud ?? '') }}">
                                            
                                            {{-- Botón Mapa --}}
                                            <button type="button" class="btn btn-link btn-sm p-0 mt-1 text-decoration-none small" onclick="abrirMapa('{{ $dia }}')">
                                                <i class="fas fa-map-marker-alt me-1 text-danger"></i> 
                                                <span id="status-{{ $dia }}">{{ (isset($h->latitud) && $h->latitud) ? 'Ubicación fijada' : 'Fijar en mapa' }}</span>
                                            </button>
                                        </div>

                                        {{-- Horas --}}
                                        <div class="col-md-3">
                                            <div class="input-group input-group-sm">
                                                <input type="time" name="horarios[{{ $dia }}][apertura]" 
                                                       class="form-control" 
                                                       value="{{ old("horarios.$dia.apertura", $h ? \Carbon\Carbon::parse($h->apertura)->format('H:i') : '') }}">
                                                <span class="input-group-text bg-light border-0 small">a</span>
                                                <input type="time" name="horarios[{{ $dia }}][cierre]" 
                                                       class="form-control" 
                                                       value="{{ old("horarios.$dia.cierre", $h ? \Carbon\Carbon::parse($h->cierre)->format('H:i') : '') }}">
                                            </div>
                                        </div>

                                        {{-- Festivo --}}
                                        <div class="col-md-2 text-end">
                                            <div class="form-check form-switch ms-2 d-inline-block">
                                                <input class="form-check-input" type="checkbox" name="horarios[{{ $dia }}][festivo_cerrado]" 
                                                       {{ (old("horarios.$dia.festivo_cerrado", $h->festivo_cerrado ?? false)) ? 'checked' : '' }}>
                                                <label class="small text-muted mb-0">Festivo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Botón Guardar Principal --}}
                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow">
                                <i class="fas fa-save me-2"></i> Guardar Todos los Cambios
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="sticky-top" style="top: 20px;">
                    <h5 class="text-secondary mb-3 ms-2 small fw-bold text-uppercase">Vista previa para clientes</h5>
                    
                    <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 25px;">
                        <div class="position-relative">
                            {{-- Carousel Preview --}}
                            <div id="previewCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
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

                            {{-- Logo Preview --}}
                            <div class="position-absolute start-50 translate-middle" style="top: 220px; z-index: 10;">
                                <div class="rounded-circle border border-4 border-white shadow bg-white" style="width: 100px; height: 100px; overflow: hidden;">
                                    <img src="{{ $negocio->imagen ? asset('storage/' . $negocio->imagen) : '' }}" id="previewLogo" class="w-100 h-100 {{ $negocio->imagen ? '' : 'd-none' }}" style="object-fit: cover;">
                                    <div id="logoPlaceholder" class="h-100 d-flex align-items-center justify-content-center bg-light {{ $negocio->imagen ? 'd-none' : '' }}">
                                        <i class="fas fa-store text-muted"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Textos Preview --}}
                        <div style="margin-top: 55px;"></div>
                        <div class="card-body p-4 text-center">
                            <h3 class="fw-bold mb-1" id="previewNombre">{{ old('nombre', $negocio->nombre) }}</h3>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-phone me-1"></i> <span id="previewTelefono">{{ old('telefono', $negocio->telefono) }}</span>
                            </p>
                            <p class="card-text text-secondary mb-4 small" id="previewDesc">
                                {{ Str::limit(old('descripcion', $negocio->descripcion), 120) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Formulario oculto para borrar imágenes (DELETE) --}}
<form id="delete-image-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

{{-- MODAL PARA EL MAPA (Selector de ubicación) --}}
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 25px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-primary" id="mapModalLabel">
                    <i class="fas fa-map-marked-alt me-2"></i>Selecciona ubicación exacta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Contenedor del Mapa --}}
                <div id="mapContainer" style="height: 450px; width: 100%; border-radius: 20px; border: 2px solid #f8f9fa;"></div>
                
                <div class="alert alert-info mt-3 border-0 small d-flex align-items-center" style="border-radius: 12px; background-color: #f0f7ff; color: #0056b3;">
                    <i class="fas fa-info-circle me-2 fa-lg"></i>
                    <div>Haz clic en el mapa para marcar el punto exacto donde montas tu puesto este día. Los campos de población y dirección se intentarán rellenar automáticamente.</div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Confirmar y cerrar</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // 1. SINCRONIZACIÓN DE PREVISUALIZACIÓN EN TIEMPO REAL
    const inputsMap = {
        'inputNombre': 'previewNombre',
        'inputTelefono': 'previewTelefono',
        'inputDesc': 'previewDesc'
    };

    Object.keys(inputsMap).forEach(inputId => {
        const inputEl = document.getElementById(inputId);
        const previewEl = document.getElementById(inputsMap[inputId]);

        if (inputEl && previewEl) {
            inputEl.addEventListener('input', () => {
                let value = inputEl.value;
                // Para la descripción, limitamos texto en preview
                if (inputId === 'inputDesc' && value.length > 120) {
                    value = value.substring(0, 120) + '...';
                }
                previewEl.innerText = value || (inputId === 'inputNombre' ? 'Nombre del Negocio' : '...');
            });
        }
    });

    // 2. PREVISUALIZACIÓN DE LOGO AL SELECCIONAR ARCHIVO
    const inputLogo = document.querySelector('input[name="imagen"]');
    if (inputLogo) {
        inputLogo.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('previewLogo');
                    img.src = e.target.result;
                    img.classList.remove('d-none');
                    document.getElementById('logoPlaceholder').classList.add('d-none');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // 3. FUNCIÓN PARA ELIMINAR FOTOS DE LA GALERÍA
    function confirmDelete(url) {
        if (confirm('¿Estás seguro de que quieres eliminar esta foto de la galería?')) {
            const form = document.getElementById('delete-image-form');
            form.action = url;
            form.submit();
        }
    }

    // --- LÓGICA DEL MAPA (Leaflet.js) ---
    let map, marker, currentDia;

    // Función para abrir el modal e inicializar/mover mapa
    function abrirMapa(dia) {
        currentDia = dia;
        const modalElement = document.getElementById('mapModal');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();

        // Esperar a que el modal se muestre para inicializar Leaflet (evita errores de tamaño)
        modalElement.addEventListener('shown.bs.modal', function () {
            if (!map) {
                // Crear mapa centrado por defecto en España
                map = L.map('mapContainer').setView([40.4167, -3.7037], 6);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                // Evento clic en el mapa
                map.on('click', function(e) {
                    actualizarPosicion(e.latlng.lat, e.latlng.lng);
                });
            }

            // Comprobar si ya hay coordenadas guardadas para este día
            const latExistente = document.getElementById(`lat-${currentDia}`).value;
            const lngExistente = document.getElementById(`lng-${currentDia}`).value;

            if (latExistente && lngExistente) {
                actualizarPosicion(latExistente, lngExistente, false); // false = no buscar dirección de nuevo al cargar
                map.setView([latExistente, lngExistente], 16); // Zoom cerca
            } else {
                if (marker) marker.remove();
                map.setView([40.4167, -3.7037], 6); // Reset vista
            }

            // Forzar a Leaflet a recalcular tamaño (soluciona cuadros grises)
            map.invalidateSize();
        }, { once: true }); // Usar once:true para no duplicar eventos
    }

    // Función para mover chincheta, guardar coordenadas y buscar dirección (Geocodificación inversa)
    async function actualizarPosicion(lat, lng, buscarDireccion = true) {
        // Mover o crear marcador
        if (marker) marker.remove();
        marker = L.marker([lat, lng]).addTo(map);

        // Guardar coordenadas en inputs ocultos
        document.getElementById(`lat-${currentDia}`).value = lat;
        document.getElementById(`lng-${currentDia}`).value = lng;
        
        // Actualizar estado visual
        document.getElementById(`status-${currentDia}`).innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Buscando dirección...';

        if (!buscarDireccion) {
            document.getElementById(`status-${currentDia}`).innerText = "Ubicación fijada";
            return;
        }

        try {
            // Llamada a la API gratuita Nominatim de OpenStreetMap (Reverse Geocoding)
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                headers: {
                    'Accept-Language': 'es' // Forzar idioma español
                }
            });
            const data = await response.json();

            if (data && data.address) {
                // 1. Extraer Población (Nominatim usa jerarquías city, town, village, municipality...)
                const poblacion = data.address.city || data.address.town || data.address.village || data.address.municipality || data.address.hamlet || "";
                
                // 2. Extraer Dirección (Calle + Número)
                const calle = data.address.road || data.address.pedestrian || "";
                const numero = data.address.house_number || "";
                const direccionFormateada = calle + (numero ? " " + numero : "");

                // Rellenar los inputs correspondientes de la vista
                if (poblacion) {
                    document.getElementById(`pob-${currentDia}`).value = poblacion;
                }
                if (direccionFormateada) {
                    document.getElementById(`ubi-${currentDia}`).value = direccionFormateada;
                }
                
                document.getElementById(`status-${currentDia}`).innerHTML = '<i class="fas fa-check-circle text-success me-1"></i>Ubicación y dirección fijadas';
            } else {
                 document.getElementById(`status-${currentDia}`).innerText = "Ubicación fijada (dirección no encontrada)";
            }
        } catch (error) {
            console.error("Error Nominatim:", error);
            document.getElementById(`status-${currentDia}`).innerText = "Ubicación fijada (error de red)";
        }
    }
</script>
@endsection
@endsection