@extends('layouts.layout')

@section('content')
<style>
    :root { --rojo-mercazone: #f53003; }

    .view-container { position: relative; min-height: 100vh; background: #f8f9fa; overflow: hidden; }

    /* --- MODO LISTA--- */
    #vistaLista { 
        padding: 2rem; 
        max-width: 1300px; 
        margin: 0 auto;
        display: block;
        height: 100vh;
        overflow-y: auto;
    }

    .business-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #eee;
        transition: 0.3s;
        height: 100%;
    }
    .business-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
    .business-card img { width: 100%; height: 200px; object-fit: cover; }

    /* --- MODO MAPA --- */
    #vistaMapa { 
        display: none;
        height: 100vh;
        width: 100%;
        position: relative; 
    }

    #mapaGlobal {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 1;
    }

    .floating-panel {
        position: absolute;
        top: 20px; left: 20px;
        width: 350px;
        max-height: calc(100vh - 100px);
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 24px;
        z-index: 1000;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .panel-header { padding: 15px; background: white; border-bottom: 1px solid #eee; }

    .scroll-area {
        flex-grow: 1;
        overflow-y: auto;
        padding: 10px;
        scrollbar-width: none;
    }
    .scroll-area::-webkit-scrollbar { display: none; }

    .map-card {
        background: white;
        border-radius: 15px;
        margin-bottom: 10px;
        transition: 0.3s;
        cursor: pointer;
        border: 1px solid transparent;
    }
    .map-card:hover { border-color: var(--rojo-mercazone); }

    .view-toggle-btn {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2000;
        background: #222;
        color: white;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        transition: 0.3s;
    }
    .view-toggle-btn:hover { background: #000; transform: translateX(-50%) scale(1.05); color: white; }

    .custom-marker {
        background-color: var(--rojo-mercazone);
        border: 3px solid white;
        border-radius: 50%;
        box-shadow: 0 0 12px rgba(0,0,0,0.4);
    }

    .btn-mercazone { background-color: var(--rojo-mercazone); color: white; border-radius: 50px; }
    .btn-mercazone:hover { background-color: #d42902; color: white; }
    .text-mercazone { color: var(--rojo-mercazone); }
</style>

<div class="view-container">
    
    <button class="view-toggle-btn" onclick="toggleView()" id="btnToggle">
        <i class="bi bi-map"></i> {{ __('index.view_map') }}
    </button>

    <div id="vistaLista">
        <div class="d-flex justify-content-between align-items-end mb-4 px-2">
            <div>
                <h2 class="fw-bold mb-0">{{ __('index.title') }}</h2>
                <p class="text-muted">{{ __('index.subtitle') }}</p>
            </div>
            <div style="width: 200px;">
                <form action="{{ route('negocios.index') }}" method="GET">
                    <select name="dia" class="form-select rounded-pill" onchange="this.form.submit()">
                        @foreach(['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'] as $d)
                            <option value="{{ $d }}" {{ $diaFiltro == $d ? 'selected' : '' }}>{{ __('index.' . $d) }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="row g-4">
            @foreach($negocios as $negocio)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="business-card shadow-sm">
                        <img src="{{ $negocio->imagen ? asset('storage/'.$negocio->imagen) : asset('img/default-shop.png') }}">
                        <div class="p-3">
                            <h6 class="fw-bold mb-1">{{ $negocio->nombre_negocio }}</h6>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-geo-alt text-mercazone"></i> 
                                {{ $negocio->horarios->where('dia', $diaFiltro)->first()->poblacion ?? __('index.location_default') }}
                            </p>
                            <a href="{{ route('negocios.show', $negocio->id) }}" class="btn btn-mercazone btn-sm w-100">{{ __('index.view_stall') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="vistaMapa">
        <div id="mapaGlobal"></div>

        <div class="floating-panel shadow">
            <div class="panel-header">
                <h5 class="fw-bold mb-3 text-mercazone"><i class="bi bi-geo-alt-fill"></i> MercaZone Map</h5>
                <form action="{{ route('negocios.index') }}" method="GET">
                    <input type="text" name="search" class="form-control rounded-pill mb-2" placeholder="{{ __('index.search_placeholder') }}" value="{{ request('search') }}">
                </form>
            </div>

            <div class="scroll-area">
                @foreach($negocios as $negocio)
                    @php 
                        $h = $negocio->horarios->where('dia', $diaFiltro)->first(); 
                    @endphp
                    <div class="map-card p-2 shadow-sm" onclick="centrarMapa({{ $h->latitud ?? 0 }}, {{ $h->longitud ?? 0 }})">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('negocios.show', $negocio->id) }}">
                                <img src="{{ $negocio->imagen ? asset('storage/'.$negocio->imagen) : asset('img/default-shop.png') }}" 
                                     class="rounded-circle border" style="width: 45px; height: 45px; object-fit: cover;">
                            </a>
                            
                            <div class="ms-2 flex-grow-1">
                                <a href="{{ route('negocios.show', $negocio->id) }}" class="text-decoration-none">
                                    <p class="fw-bold mb-0 small text-dark">{{ $negocio->nombre_negocio }}</p>
                                </a>

                                <p class="text-mercazone mb-0 fw-bold" style="font-size: 0.7rem;">
                                    <i class="bi bi-clock"></i> 
                                    @if($h && $h->apertura)
                                        {{ \Carbon\Carbon::parse($h->apertura)->format('H:i') }} - {{ \Carbon\Carbon::parse($h->cierre)->format('H:i') }}
                                    @else
                                        {{ __('index.closed') }}
                                    @endif
                                </p>
                                <p class="text-muted mb-0" style="font-size: 0.7rem;">{{ $h->poblacion ?? '' }}</p>
                            </div>
                            
                            <div class="text-muted pe-2">
                                <i class="bi bi-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleView() {
        const lista = document.getElementById('vistaLista');
        const mapa = document.getElementById('vistaMapa');
        const btn = document.getElementById('btnToggle');

        if (lista.style.display === "none") {
            lista.style.display = "block";
            mapa.style.display = "none";
            btn.innerHTML = '<i class="bi bi-map"></i> {{ __('index.view_map') }}';
        } else {
            lista.style.display = "none";
            mapa.style.display = "block";
            btn.innerHTML = '<i class="bi bi-list"></i> {{ __('index.view_list') }}';
            
            // Re-renderizar mapa para evitar cuadros grises
            setTimeout(() => { map.invalidateSize(); }, 300);
        }
    }

    // --- CONFIGURACIÓN DEL MAPA ---
    var map = L.map('mapaGlobal', { zoomControl: false }).setView([40.41, -3.70], 6);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png').addTo(map);
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    var markers = L.featureGroup();
    var puntos = @json($puntosMapa);
    var mercaIcon = L.divIcon({ className: 'custom-marker', iconSize: [18, 18], iconAnchor: [9, 9] });

    puntos.forEach(function (p) {
        if (p.lat && p.lng) {
            let imagenUrl = p.logo ? p.logo : '/img/default-shop.png';

            L.marker([p.lat, p.lng], { icon: mercaIcon }).addTo(markers).bindPopup(`
                <div class="text-center p-1" style="min-width: 120px;">
                    <div class="mb-2">
                        <img src="${imagenUrl}" 
                             class="rounded-circle shadow-sm" 
                             style="width:50px; height:50px; object-fit:cover; border:2px solid var(--rojo-mercazone);">
                    </div>
                    <h6 class="fw-bold mb-1" style="font-size:14px; color:#333;">${p.nombre_negocio}</h6>
                    <p class="text-muted mb-2" style="font-size:11px;">${p.pob || ''}</p>
                    <a href="${p.url}" class="btn btn-danger btn-sm rounded-pill text-white w-100" 
                       style="background:#f53003; border:none; font-size:11px; padding: 5px 10px;">
                       ${'{{ __('index.js_view_profile') }}'}
                    </a>
                </div>
            `);
        }
    });

    markers.addTo(map);
    if (puntos.length > 0) map.fitBounds(markers.getBounds().pad(0.2));

    function centrarMapa(lat, lng) {
        if(lat != 0) map.flyTo([lat, lng], 15);
    }
</script>
@endsection