@extends('layouts.layout')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0" style="height: calc(100vh - 70px);">

            <div id="columna-scroll" class="col-lg-4 col-md-5 bg-light p-4 overflow-auto"
                style="height: 100%; scrollbar-width: none;">
                <h2 class="fw-bold mb-4">Comercios Cercanos</h2>

                <form action="{{ route('negocios.index') }}" method="GET" class="mb-4">
                    <input type="text" name="search" class="form-control rounded-pill mb-2" placeholder="Nombre o ciudad..."
                        value="{{ request('search') }}">
                    <select name="dia" class="form-select rounded-pill shadow-sm text-capitalize"
                        onchange="this.form.submit()">
                        @foreach(['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'] as $d)
                            <option value="{{ $d }}" {{ $diaFiltro == $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </form>
                @foreach($negocios as $negocio)
                    <div class="card border-0 shadow-sm mb-4 card-negocio"
                        style="border-radius: 24px; transition: transform 0.3s ease;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ $negocio->imagen ? asset('storage/' . $negocio->imagen) : asset('img/default-shop.png') }}"
                                        class="rounded-circle shadow-sm"
                                        style="width: 70px; height: 70px; object-fit: cover; border: 3px solid #f8f9fa;">
                                </div>

                                <div class="flex-grow-1 ms-3">
                                    <h5 class="fw-bold mb-1 text-dark">{{ $negocio->nombre_negocio }}</h5>
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                        {{-- Acceso a relación Horarios --}}
                                        @php $horarioActual = $negocio->horarios->where('dia', $diaFiltro)->first(); @endphp
                                        {{ $horarioActual->Ciudad ?? 'Ubicación no disponible' }}
                                    </p>
                                    <a href="{{ route('negocios.show', $negocio->id) }}"
                                        class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                                        Ver Puesto
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div id="loading-mensaje" class="text-center py-3" style="display: none;">
                    <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
                    <p class="mt-2 text-muted small">Cargando más puestos...</p>
                </div>
            </div>

            <div class="col-lg-8 col-md-7">
                <div id="mapaGlobal" style="width:100%; height:100%;"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // --- 1. MAPA (Leaflet) ---
        var map = L.map('mapaGlobal').setView([40.4167, -3.7037], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        var markers = L.featureGroup();

        // Dibujamos los puntos que vienen del controlador
        var puntos = @json($puntosMapa);
        puntos.forEach(function (p) {
            if (p.lat && p.lng) {
                L.marker([p.lat, p.lng]).addTo(markers).bindPopup(`
                                <div class="text-center">
                                    <img src="${p.logo}" class="rounded-circle mb-2" style="width:40px; height:40px; object-fit:cover;">
                                    <h6 class="fw-bold mb-1">${p.nombre}</h6>
                                    <a href="${p.url}" class="btn btn-primary btn-sm rounded-pill text-white w-100">Ver Perfil</a>
                                </div>
                            `);
            }
        });
        markers.addTo(map);
        if (puntos.length > 0) map.fitBounds(markers.getBounds().pad(0.1));

        // --- 2. LÓGICA DE PAGINACIÓN AJAX (Infinite Scroll) ---
        let page = 1;
        let stopScroll = false;

        // Detectamos el scroll en el div de la izquierda
        $('#columna-scroll').on('scroll', function () {
            let div = $(this);
            // Si el usuario llega al fondo del scroll (menos 50px de margen)
            if (div.scrollTop() + div.innerHeight() >= div[0].scrollHeight - 50) {
                if (!stopScroll) {
                    stopScroll = true; // Pausamos para no duplicar peticiones
                    page++;
                    cargarMasPuestos(page);
                }
            }
        });

        function cargarMasPuestos(pageNumber) {
            $('#loading-mensaje').show();

            $.ajax({
                url: "{{ route('negocios.index') }}",
                data: {
                    page: pageNumber,
                    search: "{{ request('search') }}",
                    dia: "{{ $diaFiltro }}"
                },
                type: "get",
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .done(function (html) {
                    // Si Laravel ya no devuelve más HTML, paramos el scroll
                    if (html.trim() === "") {
                        $('#loading-mensaje').html('<span class="text-muted small">No hay más comercios disponibles</span>');
                        stopScroll = true;
                        return;
                    }

                    // Pegamos el contenido de tu _cards al final del listado
                    $("#lista-negocios").append(html);
                    $('#loading-mensaje').hide();
                    stopScroll = false; // Listos para pedir la siguiente página si hace falta
                })
                .fail(function () {
                    $('#loading-mensaje').hide();
                    stopScroll = false;
                });
        }
    </script>
@endsection