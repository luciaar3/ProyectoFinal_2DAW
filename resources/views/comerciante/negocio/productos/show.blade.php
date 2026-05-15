@extends('layouts.layout')

@section('content')
<style>
    :root { 
        --mercazone-accent: #f53003; 
        --mercazone-sage: #4a5d4e;
        --glass-bg: rgba(255, 255, 255, 0.7);
    }

    .main-wrapper { 
        background: radial-gradient(circle at top right, #fdfbfb 0%, #ebedee 100%);
        padding-top: 80px;
    }

    .product-visual-container {
        position: relative;
        height: 100%;       
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-img-main {
        border-radius: 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        transition: transform 0.5s ease;
        aspect-ratio: 1 / 1;      /* Fuerza a que sea un cuadrado perfecto */
        object-fit: cover;
    }

    .info-panel {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 40px;
        padding: 40px;
        height: 100%;          
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .variant-pill {
        cursor: pointer;
        padding: 12px 24px;
        border: 2px solid #eee;
        border-radius: 18px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        display: inline-block;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .btn-check:checked + .variant-pill {
        background: var(--mercazone-sage);
        border-color: var(--mercazone-sage);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(74, 93, 78, 0.2);
    }

    .btn-check:disabled + .variant-pill {
        opacity: 0.4;
        text-decoration: line-through;
    }

    .btn-reserve {
        background: #222;
        color: white;
        border: none;
        padding: 20px;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        transition: 0.4s;
    }

    .btn-reserve:hover {
        background: var(--mercazone-accent);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(245, 48, 3, 0.3);
    }

    .qty-input {
        background: #f1f1f1;
        border: none;
        font-weight: bold;
        width: 70px;
        height: 60px;
        text-align: center;
        border-radius: 18px;
    }

    .back-btn {
        background: white;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: 0.3s;
    }
    .back-btn:hover { transform: translateX(-5px); color: var(--mercazone-accent); }

    .fav-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .fav-btn i.fas.fa-heart {
        animation: pulse 0.3s ease-in-out;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
</style>

<div class="main-wrapper min-height: 100vh; pb-5">
    <div class="container">
        {{-- Header --}}
        <div class="d-flex align-items-center gap-3 mb-5">
            <a href="{{ route('negocios.show', $producto->negocio->id) }}" class="back-btn text-dark text-decoration-none">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <p class="text-muted small mb-0">Volver a la tienda</p>
                <h5 class="fw-bold mb-0">{{ $producto->negocio->nombre_negocio }}</h5>
            </div>
        </div>

        <div class="row g-5 align-items-center">
            {{-- Columna Imagen --}}
            <div class="col-lg-6">
                <div class="product-visual-container position-relative"> {{-- Asegúrate de que tenga position-relative --}}
                    <img src="{{ $producto->imagen ? asset('storage/' . $producto->imagen) : 'https://via.placeholder.com/800' }}" 
                        class="w-100 product-img-main" 
                        alt="{{ $producto->nombre }}">
     
                    <div class="position-absolute top-0 start-0 m-4">
                        <form action="{{ route('productos.favorito', $producto->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center fav-btn" 
                                    style="width: 55px; height: 55px; border: none; transition: 0.3s;">
                                @if(auth()->check() && auth()->user()->favoritos->contains($producto->id))
                                    <i class="fas fa-heart text-danger fs-4"></i>
                                @else
                                    <i class="far fa-heart text-secondary fs-4"></i>
                                @endif
                            </button>
                        </form>
                    </div>

                    <div class="position-absolute top-0 end-0 m-4">
                        <span class="badge bg-white text-dark shadow-sm p-3 rounded-4">
                            <i class="fas fa-check-circle text-success me-1"></i> Stock: {{ $producto->stock }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Columna Información --}}
            <div class="col-lg-6" >
                <div class="info-panel shadow-sm">
                    <span class="text-uppercase tracking-widest text-muted small fw-bold">Producto Local</span>
                    <h1 class="display-4 fw-bold mt-2 mb-3" style="letter-spacing: -1px;">{{ $producto->nombre }}</h1>
                    
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <h2 class="text-mercazone fw-bold mb-0 fs-1">{{ number_format($producto->precio, 2) }}€</h2>
                        <div class="vr"></div>
                        <span class="text-muted">IVA incluido</span>
                    </div>

                    <p class="fs-5 text-secondary mb-5 leading-relaxed">
                        {{ $producto->descripcion }}
                    </p>

                    <form action="{{ route('productos.reservar', $producto->id) }}" method="POST">
                        @csrf
                        
                        {{-- Variantes --}}
                        @if($producto->variantes->count() > 0)
                            @foreach($producto->variantes->groupBy('tipo') as $tipo => $opciones)
                                <div class="mb-5">
                                    <label class="fw-bold text-dark mb-3 d-block">Selecciona {{ $tipo }}</label>
                                    <div class="d-flex gap-3 flex-wrap">
                                        @foreach($opciones as $v)
                                            <div class="variant-item">
                                                <input type="radio" class="btn-check" 
                                                       name="variante_{{ Str::slug($tipo) }}" 
                                                       id="v-{{ $v->id }}" 
                                                       value="{{ $v->nombre_valor }}" 
                                                       {{ $v->stock <= 0 ? 'disabled' : '' }} required>
                                                
                                                <label class="variant-pill" for="v-{{ $v->id }}">
                                                    {{ $v->nombre_valor }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        {{-- SECCIÓN PUNTO DE RECOGIDA --}}
                        <div class="mb-4 pt-4 border-top">
                            <h5 class="fw-bold text-dark mb-3">
                                <i class="fas fa-map-marker-alt text-sage me-2"></i>¿Dónde y cuándo lo recoges?
                            </h5>

                            <div class="mb-3">
                                <select name="horario_negocio_id" class="form-select rounded-4 p-3 border-light-subtle shadow-sm" required>
                                    <option value="" selected disabled>Selecciona el mercadillo/puesto...</option>
                                    @foreach($horarios as $h)
                                        <option value="{{ $h->id }}">
                                            {{ $h->ubicacion }} ({{ $h->poblacion }}) — Cada {{ ucfirst($h->dia) }} de {{ \Carbon\Carbon::parse($h->apertura)->format('H:i') }} a {{ \Carbon\Carbon::parse($h->cierre)->format('H:i') }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text text-muted small mt-2">
                                    <i class="fas fa-info-circle me-1"></i> El comerciante preparará tu pedido para el próximo día que monte este puesto.
                                </div>
                            </div>
                        </div>

                        {{-- Footer del Formulario --}}
                        <div class="d-flex gap-3 pt-4 border-top mt-5">
                            <div class="text-center">
                                <label class="small fw-bold text-muted d-block mb-2">Uds.</label>
                                <input type="number" name="cantidad" 
                                       class="qty-input" 
                                       value="1" min="1" max="{{ $producto->stock }}">
                            </div>
                            
                            <button type="submit" class="btn-reserve flex-grow-1 fs-5 fw-bold">
                                <i class="fas fa-calendar-check me-2"></i> Confirmar Reserva
                            </button>
                        </div>
                    </form>

                    {{-- Garantías --}}
                    <div class="row mt-5 pt-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2 small text-muted">
                                <i class="fas fa-store-alt text-sage"></i>
                                Recogida en puesto local
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2 small text-muted">
                                <i class="fas fa-shield-alt text-sage"></i>
                                Pago seguro al recoger
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection