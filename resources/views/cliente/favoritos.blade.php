@extends('layouts.layout')

@section('title', __('favorites.page_title'))

@section('content')
<div class="container mt-5 pt-4 mb-5">
    
    <div class="row mb-5">
        <div class="col-12">
            <div class="p-4 p-md-5 shadow-sm d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-4" 
                 style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%); border-radius: 24px; border: 1px solid rgba(0,0,0,0.05);">
                <div>
                    <span class="badge mb-1 text-white px-3 py-1 rounded-pill" style="background-color: #f53003; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">{{ __('favorites.badge') }}</span>
                    <h1 class="fw-bolder text-dark mb-1" style="letter-spacing: -1px;">{{ __('favorites.title') }}</h1>
                    <p class="text-secondary mb-0 fs-5">{{ __('favorites.subtitle') }}</p>
                </div>
                <div>
                    <a href="{{ route('cliente.account') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm transition-hover bg-white">
                        <i class="bi bi-arrow-left me-2"></i>{{ __('favorites.back_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($favoritos->isEmpty())
        <div class="row justify-content-center py-5">
            <div class="col-12 text-center">
                <div class="p-5 bg-white shadow-sm mx-auto" style="border-radius: 24px; max-width: 500px; border: 1px solid rgba(0,0,0,0.05);">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 80px; height: 80px; background-color: #ffebee; color: #f53003;">
                        <i class="bi bi-heartbreak fs-1"></i>
                    </div>
                    <h4 class="fw-bolder text-dark mb-1">{{ __('favorites.empty_title') }}</h4>
                    <p class="text-muted small mb-4">{{ __('favorites.empty_desc') }}</p>
                    <a href="{{ route('negocios.index') }}" class="btn text-white rounded-pill px-4 fw-bold shadow-sm transition-hover" style="background-color: #f53003; border: none;">
                        <i class="bi bi-shop me-2"></i>{{ __('favorites.empty_btn') }}
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($favoritos as $p)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm transition-hover position-relative overflow-hidden bg-white d-flex flex-column" 
                         style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.03) !important;">
                        
                        <div class="position-relative overflow-hidden bg-light" style="aspect-ratio: 1 / 1;">
                            <img src="{{ $p->imagen ? asset('storage/'.$p->imagen) : 'https://via.placeholder.com/400x400?text='.urlencode($p->nombre) }}" 
                                 class="w-100 h-100 object-fit-cover transition-img" 
                                 alt="{{ $p->nombre }}">
                            
                            <div class="price-minimal shadow-sm fw-extrabold">{{ number_format($p->precio, 2, ',', '.') }}€</div>
                            
                            <form action="{{ route('productos.favorito', $p->id) }}" method="POST" class="position-absolute top-0 end-0 m-3 z-3">
                                @csrf
                                <button type="submit" class="btn btn-fav-active rounded-circle shadow-sm d-flex align-items-center justify-content-center" 
                                        title="{{ __('favorites.remove_title') }}" style="width: 38px; height: 38px; padding: 0; background-color: rgba(255, 255, 255, 0.95); border: none;">
                                    <i class="bi bi-heart-fill text-danger fs-6"></i>
                                </button>
                            </form>
                        </div>

                        <div class="card-body p-3 d-flex flex-column flex-grow-1">
                            <h6 class="fw-bolder text-dark mb-1 text-truncate" style="letter-spacing: -0.3px;">{{ $p->nombre }}</h6>
                            
                            <p class="text-secondary small mb-2 text-truncate-2-lines" style="line-height: 1.4; min-height: 2.8em;">
                                {{ $p->descripcion ?? __('favorites.no_description') }}
                            </p>
                            
                            <div class="d-flex align-items-center gap-1.5 text-muted small mb-3">
                                <i class="bi bi-shop-window text-dark"></i>
                                <span class="text-truncate fw-medium">{{ $p->negocio->nombre_negocio }}</span>
                            </div>
                            
                            <div class="mt-auto pt-2">
                                <a href="{{ route('productos.show', $p->id) }}" class="btn btn-outline-dark btn-sm rounded-pill w-100 fw-bold py-2 transition-hover">
                                    <i class="bi bi-eye me-1.5"></i>{{ __('favorites.view_product') }}
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .transition-hover {
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-6px) !important;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
    }
    .transition-img { 
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); 
    }
    .card:hover .transition-img { 
        transform: scale(1.08); 
    }
    .price-minimal {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(4px);
        padding: 4px 14px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.85rem;
        color: #1a1a1a;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .btn-fav-active:hover {
        transform: scale(1.1);
        background-color: #ffffff !important;
    }
    .btn-fav-active:hover .bi-heart-fill {
        color: #b71c1c !important;
    }
    .text-truncate-2-lines {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
    .fw-extrabold { font-weight: 800; }
</style>
@endsection