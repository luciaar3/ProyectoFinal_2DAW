@extends('layouts.layout')

@section('content')
<div class="container py-5 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="fw-bold" style="color: #2d2a26;">Mis Favoritos</h2>
        <a href="{{ route('cliente.account') }}" class="btn btn-outline-secondary rounded-pill">Volver al Panel</a>
    </div>

    @if($favoritos->isEmpty())
        <div class="text-center py-5 bg-white rounded-5 shadow-sm">
            <i class="fas fa-heart-broken fs-1 text-muted mb-3"></i>
            <h4 class="fw-bold text-dark">No tienes productos favoritos</h4>
            <p class="text-secondary">Explora los comercios y guarda los productos que te encanten.</p>
            <a href="{{ route('negocios.index') }}" class="btn btn-primary rounded-pill mt-3 px-4" style="background-color: #6b7a63; border: none;">Ir a Comercios</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($favoritos as $p)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-minimal card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                        
                        <div class="position-relative overflow-hidden shadow-sm" style="aspect-ratio: 1 / 1;">
                            <img src="{{ $p->imagen ? asset('storage/'.$p->imagen) : 'https://via.placeholder.com/300' }}" class="w-100 h-100 object-fit-cover transition-img">
                            <div class="price-minimal shadow-sm">{{ number_format($p->precio, 2) }}€</div>
                            <!-- Botón de quitar de favoritos -->
                            <form action="{{ route('productos.favorito', $p->id) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                                @csrf
                                <button type="submit" class="btn btn-danger rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; padding: 0;">
                                    <i class="fas fa-heart" style="font-size: 0.8rem;"></i>
                                </button>
                            </form>
                        </div>
                        <div class="p-3 d-flex flex-column h-100">
                            <h6 class="fw-bold mb-1 text-dark text-truncate">{{ $p->nombre }}</h6>
                            <p class="text-muted small mb-2 text-truncate">{{ $p->descripcion }}</p>
                            <p class="text-secondary small mb-3"><i class="fas fa-store me-1"></i> {{ $p->negocio->nombre_negocio }}</p>
                            
                            <div class="mt-auto">
                                <a href="{{ route('negocios.show', $p->negocio_id) }}" class="btn btn-outline-dark btn-sm rounded-pill w-100 fw-bold">Ver en tienda</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .text-sage { color: #4a5d4e !important; }
    .transition-img { transition: transform 0.5s ease; }
    .product-minimal:hover .transition-img { transform: scale(1.1); }
    
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
</style>
@endsection
