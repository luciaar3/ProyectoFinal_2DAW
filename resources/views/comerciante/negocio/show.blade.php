@extends('layouts.layout')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-8">
            <div id="carouselGaleria" class="carousel slide rounded-4 overflow-hidden shadow-sm mb-4" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($negocio->imagenes as $key => $img)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/'.$img->ruta) }}" class="d-block w-100" style="height:450px; object-fit:cover;">
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselGaleria" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselGaleria" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

            <div class="card border-0 shadow-sm p-4 rounded-4 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('storage/'.$negocio->imagen) }}" class="rounded-circle border shadow-sm me-3" style="width:80px; height:80px; object-fit:cover;">
                    <div>
                        <h2 class="fw-bold mb-0 text-primary">{{ $negocio->nombre }}</h2>
                        <p class="text-muted"><i class="fas fa-phone me-1"></i> {{ $negocio->telefono }}</p>
                    </div>
                </div>
                <h5 class="fw-bold mt-3">Sobre nosotros</h5>
                <p class="text-secondary">{{ $negocio->descripcion }}</p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 rounded-4 sticky-top" style="top: 20px;">
                <h5 class="fw-bold mb-4 text-primary"><i class="fas fa-calendar-alt me-2"></i>Ruta Semanal</h5>
                <div class="timeline-public">
                    @foreach(['lunes','martes','miercoles','jueves','viernes','sabado','domingo'] as $d)
                        @php $h = $negocio->horarios->where('dia', $d)->first(); @endphp
                        <div class="mb-3 p-3 rounded-3 {{ $h && $h->dia == $diaHoy ? 'bg-primary text-white shadow' : 'bg-light text-muted opacity-75' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="fw-bold text-capitalize">{{ $d }}</span>
                                @if($h && !$h->festivo_cerrado)
                                    <span class="badge {{ $h->dia == $diaHoy ? 'bg-white text-primary' : 'bg-primary' }} rounded-pill">{{ $h->apertura }} - {{ $h->cierre }}</span>
                                @endif
                            </div>
                            @if($h && !$h->festivo_cerrado)
                                <div class="mt-1 small">
                                    <i class="fas fa-map-marker-alt"></i> {{ $h->poblacion }}<br>
                                    <span class="opacity-75">{{ $h->ubicacion }}</span>
                                    <div class="mt-2">
                                        <a href="https://www.google.com/maps?q={{ $h->latitud }},{{ $h->longitud }}" target="_blank" class="text-decoration-none {{ $h->dia == $diaHoy ? 'text-white border-bottom border-white' : 'text-primary border-bottom border-primary' }}">Cómo llegar <i class="fas fa-external-link-alt ms-1" style="font-size:0.7rem"></i></a>
                                    </div>
                                </div>
                            @else
                                <div class="mt-1 small italic">Cerrado / Sin ruta</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection