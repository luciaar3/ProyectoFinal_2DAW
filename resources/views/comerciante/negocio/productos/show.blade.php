@extends('layouts.layout')

@section('content')
<div class="main-wrapper" style="background-color: #faf9f6; min-height: 100vh; padding-top: 50px;">
    <div class="container">
        {{-- Enlace de retorno --}}
        <a href="{{ route('negocios.show', $producto->negocio->id) }}" class="text-decoration-none text-muted small mb-4 d-inline-block">
            <i class="fas fa-arrow-left me-1"></i> Volver a {{ $producto->negocio->nombre_negocio }}
        </a>

        <div class="card border-0 shadow-lg rounded-5 overflow-hidden bg-white">
            <div class="row g-0">
                {{-- Imagen del Producto --}}
                <div class="col-md-6">
                    <img src="{{ $producto->imagen ? asset('storage/'.$producto->imagen) : 'https://via.placeholder.com/500' }}" 
                         class="w-100 h-100" style="object-fit: cover; min-height: 450px;">
                </div>

                {{-- Información y Formulario --}}
                <div class="col-md-6 p-4 p-md-5">
                    <span class="badge bg-soft-sage text-sage px-3 rounded-pill mb-2">Producto disponible</span>
                    <h1 class="fw-bold mb-1" style="color: #2d2a26;">{{ $producto->nombre }}</h1>
                    <div class="text-sage fw-bold fs-2 mb-4">{{ number_format($producto->precio, 2) }}€</div>
                    
                    <p class="text-secondary mb-5">{{ $producto->descripcion }}</p>

                    <form action="{{ route('productos.reservar', $producto->id) }}" method="POST">
                        @csrf
                        
                        {{-- Renderizado dinámico de variantes (Talla, Color, etc.) --}}
                        @if($producto->variantes->count() > 0)
                            @foreach($producto->variantes->groupBy('tipo') as $tipo => $opciones)
                                <div class="mb-4">
                                    <label class="fw-bold small mb-2 d-block text-uppercase text-muted">{{ $tipo }}</label>
                                    <div class="d-flex gap-2 flex-wrap">
                                        @foreach($opciones as $v)
                                            {{-- IMPORTANTE: El value ahora es $v->nombre_valor para guardarlo como texto --}}
                                            <input type="radio" class="btn-check" 
                                                   name="variante_{{ Str::slug($tipo) }}" 
                                                   id="v-{{ $v->id }}" 
                                                   value="{{ $v->nombre_valor }}" 
                                                   {{ $v->stock <= 0 ? 'disabled' : '' }} required>
                                            
                                            <label class="btn btn-outline-dark rounded-pill px-3" for="v-{{ $v->id }}">
                                                {{ $v->nombre_valor }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        {{-- Cantidad y Botón de Reserva --}}
                        <div class="d-flex gap-3 align-items-end mt-5">
                            <div style="width: 100px;">
                                <label class="small fw-bold text-muted mb-2 text-uppercase">Cantidad</label>
                                <input type="number" name="cantidad" 
                                       class="form-control rounded-pill text-center border-2 shadow-sm" 
                                       value="1" min="1" max="{{ $producto->stock }}">
                            </div>
                            <button type="submit" class="btn btn-dark btn-lg flex-grow-1 rounded-pill fw-bold shadow-sm py-3">
                                <i class="fas fa-calendar-check me-2"></i> Reservar ahora
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-sage { color: #4a5d4e !important; }
    .bg-soft-sage { background-color: #f0f2ef; }
    .btn-outline-dark { border-color: #dee2e6; color: #2d2a26; }
    .btn-check:checked + .btn-outline-dark {
        background-color: #4a5d4e !important;
        border-color: #4a5d4e !important;
        color: white !important;
    }
    .form-control:focus {
        border-color: #4a5d4e;
        box-shadow: none;
    }
</style>
@endsection