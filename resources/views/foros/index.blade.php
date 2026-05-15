@extends('layouts.layout')

@section('title', 'Foros de Tiendas')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h1 class="display-5 fw-bold mb-0" style="color: #2d3748;">Foros de la Comunidad</h1>
                <a href="{{ Auth::user()->rol === 'Cliente' ? route('cliente.account') : (Auth::user()->rol === 'Comerciante' ? route('comerciante.account') : route('admin.account')) }}"
                    class="btn btn-outline-secondary rounded-pill">Volver al Panel</a>
            </div>
        </div>

        <div class="row g-4">
            @forelse($negocios as $negocio)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 15px; overflow: hidden;">
                        <div class="position-relative">
                            <img src="{{ $negocio->imagen ? asset('storage/' . $negocio->imagen) : 'https://via.placeholder.com/300x200?text=Sin+Imagen' }}"
                                class="card-img-top" alt="{{ $negocio->nombre_negocio }}"
                                style="height: 180px; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-dark bg-opacity-50 text-white">
                                <h5 class="card-title mb-0 text-truncate">{{ $negocio->nombre_negocio }}</h5>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($negocio->descripcion, 80) }}
                            </p>
                            <a href="{{ route('foros.show', $negocio->id) }}" class="btn w-100 rounded-pill fw-bold"
                                style="background-color: #7b52d9; color: white;">
                                <i class="bi bi-chat-dots me-2"></i>Visitar Foro
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info rounded-pill">
                        No hay tiendas disponibles con foro en este momento.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .transition-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .transition-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection