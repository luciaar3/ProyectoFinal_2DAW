@extends('layouts.layout')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Descubre Tiendas Locales</h2>

    <div class="row g-4">
        @foreach($negocios as $n)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <img src="{{ asset('storage/'.$n->imagen) }}" class="card-img-top" style="height: 200px; object-fit: cover;">

                    <div class="card-body">
                        <h5 class="fw-bold text-primary">{{ $n->nombre }}</h5>
                        <p class="text-muted small text-truncate">{{ $n->descripcion }}</p>

                        <a href="{{ route('negocios.show', $n->id) }}" class="btn btn-outline-primary w-100 rounded-pill fw-bold">
                            Visitar Tienda
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Comercios</h4>
                <p>Explora tiendas cercanas.</p>
                <button class="btn btn-outline-primary">Ver tiendas</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Mis Reservas</h4>
                <p>Gestiona tus pedidos activos.</p>
                <button class="btn btn-outline-primary">Ver reservas</button>
            </div>
        </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Productos favoritos</h4>
                <p>Échale un ojo a tus productos favoritos.</p>
                <button class="btn btn-outline-primary">Ver favoritos</button>
            </div>
        </div>
    </div>
</div>
@endsection
