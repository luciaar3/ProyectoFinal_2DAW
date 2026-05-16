@extends('layouts.layout')

@section('content')
<style>
    :root { 
        --rojo-mercazone: #f53003; 
        --crema-mercazone: #fcfaf5; 
        --mint-mercazone: #e8f3ee;  
        --negro-text: #333333;
    }
    .btn-volver {
        position: absolute;
        top: 30px;
        left: 30px;
        z-index: 9999;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 10px 20px;
        border-radius: 50px;
        color: white !important;
        text-decoration: none;
        font-weight: 700;
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-volver:hover {
        background: var(--rojo-mercazone);
        color: white !important;
        transform: scale(1.05);
    }

    .btn-volver i {
        font-size: 1.2rem;
    }

    .main-wrapper { background-color: var(--crema-mercazone); min-height: 100vh; }

    /* --- CARRUSEL --- */
    .hero-banner {
        height: 550px;
        position: relative;
        background-color: #000;
        overflow: hidden;
    }
    .hero-banner .carousel, .hero-banner .carousel-inner, .hero-banner .carousel-item {
        height: 100%;
    }
    .hero-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.85);
    }
    .hero-banner-fade {
        position: absolute; bottom: 0; left: 0; width: 100%;
        height: 180px;
        background: linear-gradient(transparent, var(--crema-mercazone));
        z-index: 5;
    }

    /* --- CARD PRINCIPAL --- */
    .profile-card { margin-top: -200px; z-index: 10; position: relative; }
    
    /* Panel Derecho*/
    .route-panel { background-color: var(--rojo-mercazone); color: white; border-radius: 0 30px 30px 0; }
    
    .status-badge {
        background-color: #28a745; 
        color: white; padding: 8px 18px; border-radius: 50px; font-weight: 700; font-size: 0.85rem;
    }

    /* --- HORARIO --- */
    .horario-list { display: flex; flex-direction: column; gap: 10px; }
    
    .horario-item {
        background: rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 12px 18px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .horario-item.activo { 
        background: white; 
        color: var(--negro-text) !important; 
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        border: none;
        padding: 18px 22px; /* Más grande hoy */
    }

    .horario-item.activo .dia-nombre { color: var(--rojo-mercazone); font-size: 1.2rem; }
    .horario-item.activo .poblacion-text { color: var(--negro-text); font-weight: 800; font-size: 1.1rem; }
    .horario-item.activo .hora-badge { background: var(--mint-mercazone); color: #2e7d32; }

    .dia-nombre { text-transform: capitalize; font-weight: 700; font-size: 0.95rem; }
    .poblacion-text { font-size: 0.9rem; opacity: 0.9; }
    
    .hora-badge {
        background: rgba(255, 255, 255, 0.15);
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* --- PRODUCTOS --- */
    .product-minimal { transition: all 0.3s ease; background: white; border-radius: 20px; overflow: hidden; }
    .product-minimal:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important; }
    .product-img-wrapper { aspect-ratio: 1 / 1; overflow: hidden; position: relative; }
    
    .product-tag {
        position: absolute; top: 12px; left: 12px;
        background-color: var(--mint-mercazone); color: #2e7d32;
        padding: 4px 10px; border-radius: 50px; font-size: 0.7rem; font-weight: 700;
    }

    .btn-mercazone { background-color: var(--rojo-mercazone); color: white; border-radius: 50px; font-weight: 700; padding: 12px 24px; border: none; transition: 0.3s; }
    .btn-mercazone:hover { background-color: #d42902; color: white; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(245, 48, 3, 0.3); }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="main-wrapper pb-5">
    <div class="container-fluid px-0 hero-banner">
        <a href="{{ route('negocios.index') }}" class="btn-volver shadow-sm">
            <i class="bi bi-arrow-left"></i>
            <span>{{ __('perfil.btn_back') }}</span>
        </a>
        <div id="carouselNegocio" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @forelse($negocio->imagenes as $key => $img)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $img->ruta) }}" alt="{{ __('perfil.alt_business_photo', ['name' => $negocio->nombre_negocio]) }}">
                    </div>
                @empty
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/'.$negocio->imagen) }}" alt="{{ __('perfil.alt_main_photo') }}">
                    </div>
                @endforelse
            </div>
            @if($negocio->imagenes->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselNegocio" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselNegocio" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            @endif
        </div>
        <div class="hero-banner-fade"></div>
    </div>

    <div class="container profile-card">
        <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-7 p-4 p-md-5 bg-white">
                    <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <div class="position-relative">
                                <img src="{{ asset('storage/'.$negocio->imagen) }}" class="rounded-circle shadow-sm me-4" style="width:120px; height:120px; object-fit:cover; border: 4px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;">
                            </div>
                            <div>
                                <h1 class="fw-bold mb-1" style="color: var(--negro-text); letter-spacing: -2px; font-size: 2.8rem;">{{ $negocio->nombre_negocio }}</h1>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill border"><i class="bi bi-shop me-1 text-mercazone"></i> {{ __('perfil.stall_no', ['number' => rand(1,50)]) }}</span>
                                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill border"><i class="bi bi-patch-check-fill me-1 text-primary"></i> {{ __('perfil.verified') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        @php 
                            $hoyH = $negocio->horarios->where('dia', $diaHoy)->first(); 
                            $abierto = $hoyH && now()->between(\Carbon\Carbon::parse($hoyH->apertura), \Carbon\Carbon::parse($hoyH->cierre));
                        @endphp

                        <div class="status-badge {{ $abierto ? '' : 'bg-secondary' }}">
                            <i class="bi {{ $abierto ? 'bi-circle-fill' : 'bi-moon-stars-fill' }} me-2" style="font-size:0.7rem;"></i>
                            {{ $abierto ? __('perfil.open_now') : __('perfil.closed') }}
                        </div>
                    </div>

                    <p class="text-muted mb-4 fs-5" style="line-height: 1.6;">{{ $negocio->descripcion }}</p>
                    
                    <div class="row g-3 pt-4 border-top">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center p-3 rounded-4 bg-light">
                                <i class="bi bi-telephone-fill fs-4 text-mercazone me-3"></i>
                                <div>
                                    <small class="text-muted d-block">{{ __('perfil.contact_phone') }}</small>
                                    <a href="tel:{{ $negocio->telefono }}" class="text-decoration-none text-dark fw-bold">{{ $negocio->telefono }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center p-3 rounded-4 bg-light">
                                <i class="bi bi-geo-alt-fill fs-4 text-mercazone me-3"></i>
                                <div>
                                    <small class="text-muted d-block">{{ __('perfil.today_location') }}</small>
                                    <span class="text-dark fw-bold">{{ $hoyH->poblacion ?? __('perfil.not_available') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <a href="{{ route('foros.show', $negocio->id) }}" class="text-decoration-none">
                            <div class="d-flex align-items-center justify-content-between p-4 rounded-4 transition-hover border border-2 shadow-sm" 
                                style="background-color: var(--mint-mercazone); border-color: rgba(245, 48, 3, 0.15) !important;">
                                
                                <div class="d-flex align-items-center">
                                    <div class="p-3 rounded-circle bg-white d-flex align-items-center justify-content-center me-4 shadow-sm" style="width: 55px; height: 55px;">
                                        <i class="bi bi-chat-square-text-fill fs-3 text-mercazone"></i>
                                    </div>
                                    <div>
                                        <span class="badge mb-1 text-white px-2 py-1 rounded-pill" style="background-color: var(--rojo-mercazone); font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">{{ __('perfil.community') }}</span>
                                        <h4 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.5px;">{{ __('perfil.forum_title') }}</h4>
                                        <p class="text-muted small mb-0 d-none d-md-block">{{ __('perfil.forum_desc') }}</p>
                                    </div>
                                </div>

                                <div class="text-mercazone d-flex align-items-center fs-4 fw-bold me-2">
                                    <i class="bi bi-arrow-right-circle-fill"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-5 p-4 p-md-5 route-panel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="text-white fw-bold mb-0">{{ __('perfil.weekly_route') }}</h4>
                        <span class="badge rounded-pill px-3 py-2" style="background: rgba(255,255,255,0.2)">
                            <i class="bi bi-calendar3 me-1"></i> {{ now()->format('M Y') }}
                        </span>
                    </div>
                    
                    <div class="horario-list">
                        @foreach(['lunes','martes','miercoles','jueves','viernes','sabado','domingo'] as $d)
                            @php $h = $negocio->horarios->where('dia', $d)->first(); @endphp
                            <div class="horario-item d-flex justify-content-between align-items-center {{ $d == $diaHoy ? 'activo' : '' }}">
                                <div>
                                    <div class="dia-nombre">{{ __('perfil.' . $d) }}</div>
                                    <div class="poblacion-text">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ $h && !$h->festivo_cerrado ? $h->poblacion : __('perfil.rest_day') }}
                                    </div>
                                </div>
                                
                                @if($h && !$h->festivo_cerrado)
                                    <div class="hora-badge">
                                        <i class="bi bi-clock"></i>
                                        {{ \Carbon\Carbon::parse($h->apertura)->format('H:i') }} - {{ \Carbon\Carbon::parse($h->cierre)->format('H:i') }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <a href="https://www.google.com/maps/search/?api=1&query={{ $hoyH->latitud ?? 0 }},{{ $hoyH->longitud ?? 0 }}" 
                       target="_blank" class="btn btn-light w-100 mt-4 rounded-pill fw-bold py-3 text-mercazone shadow-lg">
                       <i class="bi bi-cursor-fill me-2"></i> {{ __('perfil.get_directions') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-5 px-1">
            <div>
                <h2 class="fw-bold mb-0 text-dark" style="letter-spacing: -1.5px;">{{ __('perfil.daily_selection') }}</h2>
                <p class="text-muted mb-0">{{ __('perfil.products_subtitle') }}</p>
            </div>
            <a href="#" class="btn btn-outline-dark rounded-pill px-4 fw-bold">{{ __('perfil.view_full_catalog') }}</a>
        </div>

        <div class="row g-4">
            @foreach($negocio->productos as $p)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-minimal card h-100 border-0 shadow-sm p-2">
                        <div class="product-img-wrapper rounded-4 mb-3">
                            <img src="{{ $p->imagen ? asset('storage/'.$p->imagen) : asset('img/default-product.png') }}" class="w-100 h-100 object-fit-cover">
                            <div class="product-tag shadow-sm">{{ __('perfil.local_stall') }}</div>
                        </div>
                        <div class="px-2 pb-2 text-center">
                            <h6 class="fw-bold mb-1 text-dark">{{ $p->nombre }}</h6>
                            <p class="text-muted small mb-3 text-truncate px-2">{{ $p->descripcion }}</p>
                            <div class="d-grid">
                                <a href="{{ route('productos.show', $p->id) }}" class="btn btn-mercazone py-2">
                                    {{ __('perfil.book_btn', ['price' => number_format($p->precio, 2)]) }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div> 
            @endforeach
        </div>
    </div>
</div>
@endsection