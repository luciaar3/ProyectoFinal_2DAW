@extends('layouts.layout')

@section('content')
<div class="main-wrapper" style="background-color: #faf9f6; min-height: 100vh;">
    
    <div class="container-fluid px-0 position-relative">
        <div id="carouselGaleria" class="carousel slide" data-bs-ride="carousel" style="height: 500px;">
            <div class="carousel-inner h-100">
                @foreach($negocio->imagenes as $key => $img)
                    <div class="carousel-item h-100 {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/'.$img->ruta) }}" class="d-block w-100 h-100" style="object-fit: cover; filter: brightness(0.85);">
                    </div>
                @endforeach
            </div>
            <div class="position-absolute bottom-0 start-0 w-100" style="height: 150px; background: linear-gradient(transparent, #faf9f6);"></div>
        </div>

        <div class="container position-relative" style="margin-top: -100px; z-index: 10;">
            <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                <div class="row g-0">
                    <div class="col-lg-7 p-4 p-md-5 bg-white">
                        <div class="d-flex align-items-center mb-4">
                            <img src="{{ asset('storage/'.$negocio->imagen) }}" class="rounded-4 shadow-sm me-4" style="width:100px; height:100px; object-fit:cover; border: 4px solid #f8f7f2;">
                            <div>
                                <h1 class="fw-bold mb-1" style="color: #2d2a26; letter-spacing: -1px;">{{ $negocio->nombre_negocio }}</h1>
                                <span class="badge bg-soft-sage text-sage px-3 rounded-pill">Comercio de confianza</span>
                            </div>
                        </div>
                        <p class="text-secondary mb-4 leading-relaxed" style="font-size: 1.05rem;">{{ $negocio->descripcion }}</p>
                        <div class="d-flex flex-wrap gap-4">
                            <a href="tel:{{ $negocio->telefono }}" class="text-decoration-none text-dark fw-bold small">
                                <i class="fas fa-phone-alt me-2 text-sage"></i> {{ $negocio->telefono }}
                            </a>
                            <div class="text-dark fw-bold small">
                                <i class="fas fa-map-marker-alt me-2 text-sage"></i> 
                                {{ $negocio->horarios->where('dia', $diaHoy)->first()->poblacion ?? 'Sin ruta hoy' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-5 p-4 p-md-5" style="background-color: #4a5d4e;">
                        <h5 class="text-white fw-bold mb-4 d-flex justify-content-between align-items-center">
                            <span>Ruta Semanal</span>
                            <i class="fas fa-calendar-day opacity-50"></i>
                        </h5>
                        <div class="horario-compacto">
                            @foreach(['lunes','martes','miercoles','jueves','viernes','sabado','domingo'] as $d)
                                @php $h = $negocio->horarios->where('dia', $d)->first(); @endphp
                                <div class="d-flex justify-content-between py-1 {{ $d == $diaHoy ? 'text-white fw-bold bg-white bg-opacity-10 rounded px-2' : 'text-white-50 small px-2' }}">
                                    <span class="text-capitalize">{{ $d }}</span>
                                    <span>
                                        @if($h && !$h->festivo_cerrado)
                                            {{ $h->poblacion }} ({{ $h->apertura }})
                                        @else
                                            Descanso
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <a href="https://www.google.com/maps?q={{ $negocio->horarios->where('dia', $diaHoy)->first()->latitud ?? '' }},{{ $negocio->horarios->where('dia', $diaHoy)->first()->longitud ?? '' }}" 
                           target="_blank" class="btn btn-light w-100 mt-4 rounded-pill fw-bold py-2 text-sage">
                           <i class="fas fa-location-arrow me-2"></i> Cómo llegar ahora
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5 mt-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #2d2a26;">Nuestra Selección</h2>
            <div class="mx-auto" style="width: 40px; height: 3px; background-color: #6b7a63; border-radius: 10px;"></div>
        </div>

        <div class="row g-4">
            @foreach($negocio->productos as $p)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-minimal card h-100 border-0 bg-transparent" 
                         style="cursor: pointer;" 
                         data-bs-toggle="modal" 
                         data-bs-target="#modalProd{{ $p->id }}">
                        
                        <div class="position-relative rounded-4 overflow-hidden mb-3 shadow-sm aspect-ratio-1">
                            <img src="{{ $p->imagen ? asset('storage/'.$p->imagen) : 'https://via.placeholder.com/300' }}" class="w-100 h-100 object-fit-cover transition-img">
                            <div class="price-minimal shadow-sm">{{ number_format($p->precio, 2) }}€</div>
                        </div>
                        <div class="px-2">
                            <h6 class="fw-bold mb-1 text-dark text-truncate">{{ $p->nombre }}</h6>
                            <p class="text-muted small mb-2 text-truncate">{{ $p->descripcion }}</p>
                            <button class="btn btn-outline-dark btn-sm rounded-pill w-100 fw-bold">Ver detalles</button>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalProd{{ $p->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 rounded-5 overflow-hidden">
                            <div class="modal-body p-0 text-center">
                                <img src="{{ $p->imagen ? asset('storage/'.$p->imagen) : 'https://via.placeholder.com/500' }}" class="w-100" style="height: 300px; object-fit: cover;">
                                <div class="p-4">
                                    <h3 class="fw-bold mb-1">{{ $p->nombre }}</h3>
                                    <div class="text-sage fw-bold fs-4 mb-3">{{ number_format($p->precio, 2) }}€</div>
                                    <p class="text-muted mb-4">{{ $p->descripcion }}</p>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="https://wa.me/34{{ $negocio->telefono }}?text=Hola, quiero reservar {{ $p->nombre }}" target="_blank" class="btn btn-success rounded-pill py-2 fw-bold">
                                            <i class="fab fa-whatsapp me-2"></i> Reservar por WhatsApp
                                        </a>
                                        <button class="btn btn-dark rounded-pill py-2 fw-bold">
                                            <i class="fas fa-shopping-cart me-2"></i> Añadir al carrito
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    /* Tipografía y Colores mejorados */
    .text-sage { color: #4a5d4e !important; }
    .bg-soft-sage { background-color: #f0f2ef; }
    .btn-sage-light { background-color: #6b7a63; color: white; border: none; }
    
    .aspect-ratio-1 { aspect-ratio: 1 / 1; }
    .transition-img { transition: transform 0.5s ease; }
    .product-minimal:hover .transition-img { transform: scale(1.1); }
    
    /* Estética unificada */
    .card { border-radius: 30px !important; }
    
    .price-minimal {
        position: absolute;
        bottom: 12px;
        right: 12px;
        background: white;
        padding: 4px 14px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.85rem;
        color: #2d2a26;
    }

    .horario-compacto {
        border-top: 1px solid rgba(255,255,255,0.15);
        padding-top: 15px;
    }

    /* Animación del Modal */
    .modal.fade .modal-dialog { transform: scale(0.9); transition: transform 0.2s ease-out; }
    .modal.show .modal-dialog { transform: scale(1); }

    .main-wrapper { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>
@endsection