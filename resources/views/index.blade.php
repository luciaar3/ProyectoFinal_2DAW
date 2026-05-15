@extends('layouts.layout')

@section('title', 'MercaZone - Tu Mercado de Proximidad Digital')

@section('content')
<style>
    :root {
        --rojo-mercazone: #f53003;
        --rojo-hover: #d42902;
    }

    /* --- FONDO --- */
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

    /* --- BUSCADOR --- */
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

    /* --- ETIQUETAS --- */
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

    /* --- CARDS --- */
    .flip-card { background-color: transparent; height: 420px; perspective: 1500px; }
    
    .flip-card-inner { 
        position: relative; 
        width: 100%; 
        height: 100%; 
        text-align: center; 
        transition: transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1); 
        transform-style: preserve-3d; 
    }
    
    .flip-card:hover .flip-card-inner { transform: rotateY(180deg) translateY(-10px); }
    
    .flip-card-front, .flip-card-back { 
        position: absolute; 
        width: 100%; 
        height: 100%; 
        backface-visibility: hidden; 
        -webkit-backface-visibility: hidden;
        border-radius: 30px; 
        overflow: hidden; 
        box-shadow: 0 12px 35px rgba(0,0,0,0.06); 
    }
    
    /* CARA FRONTAL */
    .flip-card-front { background: #ffffff; display: flex; flex-direction: column; transform: rotateY(0deg); }
    .card-header-front { padding: 30px 20px 15px 20px; text-align: center; position: relative; z-index: 2; background: #ffffff; }
    
    .tarjeta-foto { 
        height: 240px; 
        margin-top: auto; 
        background-size: cover; 
        background-position: center; 
        position: relative; 
    }
    
    .tarjeta-foto::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 60px; 
        background: linear-gradient(to bottom, #ffffff 0%, rgba(255, 255, 255, 0) 100%);
        z-index: 1;
    }
    
    .flip-card-back { 
        transform: rotateY(180deg); 
        display: flex; 
        flex-direction: column; 
        justify-content: center; 
        align-items: center; 
        padding: 2.5rem; 
        background: #ffffff !important;
        border: 1px solid rgba(0,0,0,0.06);
    }

    .icon-box {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        margin-bottom: 1.5rem;
        box-shadow: inset 0 -4px 0 rgba(0,0,0,0.04);
    }
    .icon-box-blue { background: #e0f2fe; color: #0284c7; }
    .icon-box-red { background: #fff5f2; color: var(--rojo-mercazone); }
    .icon-box-green { background: #dcfce7; color: #16a34a; }

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
                        <div class="tarjeta-foto" style="background-image: url('{{ asset('storage/img/mapa.webp') }}');"></div>
                    </div>
                    <div class="flip-card-back">
                        <div class="icon-box icon-box-blue">
                            <i class="bi bi-map fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Encuentra la Ruta</h5>
                        <p class="text-secondary small text-center mb-4">Mira dónde están tus comerciantes favoritos hoy mismo.</p>
                        <a href="{{ route('negocios.index') }}" class="btn btn-dark rounded-pill px-4 shadow-sm">Ver Mapa</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-8 card-destacada">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front" style="border: 2px solid var(--rojo-mercazone);">
                        <div class="card-header-front">
                            <span class="badge bg-danger mb-2 px-3 py-2 rounded-pill" style="background-color: var(--rojo-mercazone) !important;">PRO</span>
                            <h4 class="fw-bolder">Soy Comerciante</h4>
                        </div>
                        <div class="tarjeta-foto" style="background-image: url('{{ asset('storage/img/comerciante.webp') }}');"></div>
                    </div>
                    <div class="flip-card-back" style="border: 2px solid var(--rojo-mercazone);">
                        <div class="icon-box icon-box-red">
                            <i class="bi bi-graph-up-arrow fs-3"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Digitaliza tu Puesto</h4>
                        <p class="text-secondary small text-center mb-4">Publica tus productos y recibe pedidos online fácilmente.</p>
                        <a href="{{ route('registro') }}" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm" style="background-color: var(--rojo-mercazone);">Empezar Ahora</a>
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
                        <div class="tarjeta-foto" style="background-image: url('{{ asset('storage/img/comunidad.webp') }}');"></div>
                    </div>
                    <div class="flip-card-back">
                        <div class="icon-box icon-box-green">
                            <i class="bi bi-stars fs-3"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Opiniones Reales</h5>
                        <p class="text-secondary small text-center mb-4">Descubre los mejores productos según tus vecinos.</p>
                        <a href="{{route('foros.index') }}" class="btn btn-dark rounded-pill px-4 shadow-sm">Leer Foros</a>
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