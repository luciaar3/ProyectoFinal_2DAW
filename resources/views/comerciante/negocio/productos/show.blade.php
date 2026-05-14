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

    /* Imagen con efecto de profundidad */
    .product-visual-container {
        position: sticky;
        top: 100px;
    }

    .product-img-main {
        border-radius: 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        transition: transform 0.5s ease;
    }

    /* Contenedor de información tipo panel flotante */
    .info-panel {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.4);
        border-radius: 40px;
        padding: 40px;
    }

    /* Estilo de variantes innovador */
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

    /* Botón de reserva animado */
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

    /* Input de cantidad minimalista */
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
</style>

<div class="main-wrapper min-height: 100vh; pb-5">
    <div class="container">
        {{-- Header con navegación limpia --}}
        <div class="d-flex align-items-center gap-3 mb-5">
            <a href="{{ route('negocios.show', $producto->negocio->id) }}" class="back-btn text-dark text-decoration-none">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <p class="text-muted small mb-0">Volver a la tienda</p>
                <h5 class="fw-bold mb-0">{{ $producto->negocio->nombre_negocio }}</h5>
            </div>
        </div>

        <div class="row g-5">
            {{-- Columna Imagen --}}
            <div class="col-lg-6">
                <div class="product-visual-container">
                    <img src="{{ $producto->imagen ? asset('storage/'.$producto->imagen) : 'https://via.placeholder.com/800' }}" 
                         class="w-100 product-img-main" 
                         alt="{{ $producto->nombre }}">
                    
                    {{-- Badge flotante --}}
                    <div class="position-absolute top-0 end-0 m-4">
                        <span class="badge bg-white text-dark shadow-sm p-3 rounded-4">
                            <i class="fas fa-check-circle text-success me-1"></i> Stock: {{ $producto->stock }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Columna Información --}}
            <div class="col-lg-6">
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
                        
                        {{-- Variantes con estética de boutique --}}
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

                    {{-- Garantías MercaZone --}}
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