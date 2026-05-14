@extends('layouts.layout')

@section('title', 'MercaZone - Tu Mercado de Proximidad Digital')

@section('content')
<style>
    :root {
        --rojo-mercazone: #f53003;
        --rojo-hover: #d42902;
    }

    /* --- FONDO DINÁMICO --- */
    body {
        background-color: #f4f4f7;
        background-image: 
            linear-gradient(to bottom, rgba(255, 255, 255, 0.8) 0%, rgba(244, 244, 247, 0.9) 100%),
            url('https://images.unsplash.com/photo-1533900298318-6b8da08a523e?q=80&w=1920&auto=format&fit=crop&blur=50'); 
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
        min-height: 100vh;
    }

    /* --- CONTENEDOR GLASSMORPHISM --- */
    .main-wrapper {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 40px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
        padding: 5rem 2rem;
        margin-top: 2rem;
        margin-bottom: 5rem;
    }

    /* --- BUSCADOR EVOLUCIONADO --- */
    .search-container {
        max-width: 850px;
        margin: 0 auto;
        transition: transform 0.3s ease;
    }

    .search-container:focus-within {
        transform: translateY(-5px);
    }

    .custom-search-bar {
        background: white;
        border-radius: 100px;
        padding: 8px;
        display: flex;
        align-items: center;
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border: 1px solid #eee;
    }

    .category-select {
        border: none;
        background: transparent;
        font-weight: 700;
        color: var(--rojo-mercazone);
        padding: 0 25px;
        cursor: pointer;
        outline: none;
        min-width: 140px;
    }

    .search-input {
        border: none;
        padding: 12px 20px;
        width: 100%;
        outline: none;
        font-size: 1.1rem;
    }

    .btn-search {
        background: var(--rojo-mercazone);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 100px;
        font-weight: 700;
        transition: 0.3s;
    }

    .btn-search:hover {
        background: var(--rojo-hover);
        box-shadow: 0 5px 15px rgba(245, 48, 3, 0.3);
    }

    /* --- ETIQUETAS/PILLS BAJO EL BUSCADOR --- */
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin-top: 25px;
    }

    .tag-pill {
        background: white;
        color: #555;
        padding: 8px 20px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .tag-pill:hover {
        background: var(--rojo-mercazone);
        color: white !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(245, 48, 3, 0.2);
    }

    /* --- ESTILOS FLIP CARDS --- */
    .flip-card { background-color: transparent; height: 420px; perspective: 1500px; }
    .flip-card-inner { position: relative; width: 100%; height: 100%; text-align: center; transition: transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1); transform-style: preserve-3d; }
    .flip-card:hover .flip-card-inner { transform: rotateY(180deg) translateY(-10px); }
    .flip-card-front, .flip-card-back { position: absolute; width: 100%; height: 100%; backface-visibility: hidden; border-radius: 30px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.03); }
    .flip-card-front { background: white; display: flex; flex-direction: column; }
    .flip-card-back { transform: rotateY(180deg); display: flex; flex-direction: column; justify-content: center; padding: 2rem; background: white; }
    
    .card-header-front { padding: 30px; text-align: left; }
    .zen-graphic { height: 220px; margin-top: auto; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
    .zen-blob-1, .zen-blob-2 { position: absolute; border-radius: 50%; filter: blur(20px); opacity: 0.6; }
    
    .zen-orange .zen-blob-1 { width: 150%; height: 150%; background: #f53003; bottom: -60%; }
    .card-destacada .flip-card { height: 460px; }

    .scroll-indicator { font-size: 2.5rem; color: var(--rojo-mercazone); animation: bounce 2s infinite; display: inline-block; }
    @keyframes bounce { 0%, 20%, 50%, 80%, 100% {transform: translateY(0);} 40% {transform: translateY(-10px);} }
</style>

<div class="container main-wrapper shadow-sm">
    <div class="text-center mb-5">
        <h1 class="display-3 fw-bolder text-dark mb-3" style="letter-spacing: -2.5px;">
            Merca<span style="color: var(--rojo-mercazone);">Zone</span>
        </h1>
        <p class="fs-5 text-secondary mx-auto mb-5" style="max-width: 700px;">
            Encuentra tus puestos favoritos, descubre nuevas rutas y apoya al comercio de tu barrio con un solo clic.
        </p>

        <div class="search-container">
            <form action="{{ route('negocios.index') }}" method="GET">
                <div class="custom-search-bar">
                    <select name="categoria" class="category-select d-none d-md-block">
                        <option value="">Categorías</option>
                        @foreach($etiquetas as $et)
                            <option value="{{ $et->nombre }}">{{ ucfirst(str_replace('_', ' y ', $et->nombre)) }}</option>
                        @endforeach
                    </select>
                    <div class="vr d-none d-md-block" style="height: 30px; align-self: center; background-color: #ccc;"></div>
                    <input type="text" name="search" class="search-input" value="{{ request('search') }}" placeholder="¿Qué estás buscando?">
                    <button type="submit" class="btn-search">
                        <i class="bi bi-search me-2"></i> Buscar
                    </button>
                </div>
            </form>

            <div class="tags-container">
                @foreach($etiquetas->take(6) as $et)
                    <a href="{{ route('negocios.index', ['categoria' => $et->nombre]) }}" class="tag-pill">
                        <i class="bi bi-lightning-charge-fill" style="color: var(--rojo-mercazone); font-size: 0.7rem;"></i>
                        {{ ucfirst(str_replace('_', ' y ', $et->nombre)) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4 mt-5 justify-content-center align-items-center">
        <div class="col-lg-4 col-md-6">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <div class="card-header-front">
                            <h5 class="fw-bold mb-1 fs-4">Explorar Mapa</h5>
                            <p class="text-secondary small">Localiza puestos en tiempo real.</p>
                        </div>
                        <div class="zen-graphic" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);">
                            <i class="bi bi-geo-alt-fill text-primary" style="font-size: 5rem;"></i>
                        </div>
                    </div>
                    <div class="flip-card-back">
                        <i class="bi bi-map fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold">Encuentra la Ruta</h5>
                        <p class="text-secondary small">Mira dónde están tus comerciantes favoritos hoy mismo.</p>
                        <a href="{{ route('negocios.index') }}" class="btn btn-dark rounded-pill px-4 mt-2">Ver Mapa</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-8 card-destacada">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front" style="border: 2px solid var(--rojo-mercazone);">
                        <div class="card-header-front text-center">
                            <span class="badge bg-danger mb-2 px-3 py-2 rounded-pill" style="background-color: var(--rojo-mercazone) !important;">PRO</span>
                            <h4 class="fw-bolder">Soy Comerciante</h4>
                        </div>
                        <div class="zen-graphic zen-orange" style="background: #fff5f2;">
                            <div class="zen-blob-1"></div>
                            <i class="bi bi-shop text-white position-relative z-3" style="font-size: 6rem; filter: drop-shadow(0 5px 15px rgba(245,48,3,0.4));"></i>
                        </div>
                    </div>
                    <div class="flip-card-back" style="background: #fff5f2; border: 2px solid var(--rojo-mercazone);">
                        <i class="bi bi-graph-up-arrow fs-1 mb-3" style="color: var(--rojo-mercazone);"></i>
                        <h4 class="fw-bold">Digitaliza tu Puesto</h4>
                        <p class="text-secondary small">Publica tus productos y recibe pedidos online fácilmente.</p>
                        <a href="{{ route('registro') }}" class="btn btn-danger rounded-pill px-4 fw-bold" style="background-color: var(--rojo-mercazone);">Empezar Ahora</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <div class="card-header-front">
                            <h5 class="fw-bold mb-1 fs-4">Comunidad</h5>
                            <p class="text-secondary small">Confianza y vecindad.</p>
                        </div>
                        <div class="zen-graphic" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
                            <i class="bi bi-people-fill text-success" style="font-size: 5rem;"></i>
                        </div>
                    </div>
                    <div class="flip-card-back">
                        <i class="bi bi-stars fs-1 text-success mb-3"></i>
                        <h5 class="fw-bold">Opiniones Reales</h5>
                        <p class="text-secondary small">Descubre los mejores productos según tus vecinos.</p>
                        <a href="#" class="btn btn-dark rounded-pill px-4 mt-2">Leer Foros</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="#nuestra-historia" class="scroll-indicator"><i class="bi bi-chevron-compact-down"></i></a>
    </div>

    <div id="nuestra-historia">
        @include('layouts.partials.history')
    </div>
</div>
@endsection