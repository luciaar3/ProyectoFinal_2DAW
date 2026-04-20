@extends('layouts.layout')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0" style="height: calc(100vh - 70px);">
        <div class="col-lg-4 col-md-5 bg-light p-4 overflow-auto">
            <h4 class="fw-bold mb-3">Encuentra puestos</h4>
            
            <form action="{{ route('negocios.index') }}" method="GET" class="mb-4">
                <input type="text" name="search" class="form-control rounded-pill mb-2" placeholder="Nombre o ciudad..." value="{{ request('search') }}">
                <select name="dia" class="form-select rounded-pill shadow-sm text-capitalize" onchange="this.form.submit()">
                    @foreach(['lunes','martes','miercoles','jueves','viernes','sabado','domingo'] as $d)
                        <option value="{{ $d }}" {{ $diaFiltro == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </form>

            @forelse($negocios as $n)
                <div class="card border-0 shadow-sm mb-3 hover-shadow transition" style="border-radius: 15px;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/'.$n->imagen) }}" class="rounded-circle me-3" style="width:60px; height:60px; object-fit:cover;">
                            <div>
                                <h6 class="fw-bold mb-0">{{ $n->nombre }}</h6>
                                <small class="text-muted"><i class="fas fa-map-marker-alt text-danger"></i> {{ $n->horarios->where('dia', $diaFiltro)->first()->poblacion }}</small>
                            </div>
                            <a href="{{ route('negocios.show', $n->id) }}" class="btn btn-primary btn-sm ms-auto rounded-pill">Ver</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <p class="text-muted">No hay puestos activos para este filtro.</p>
                </div>
            @endforelse
        </div>

        <div class="col-lg-8 col-md-7">
            <div id="mapaGlobal" style="width:100%; height:100%;"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var map = L.map('mapaGlobal').setView([40.4167, -3.7037], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var puntos = @json($puntosMapa);
    var markers = L.featureGroup();

    puntos.forEach(function(p) {
        if(p.lat && p.lng) {
            var marker = L.marker([p.lat, p.lng]).addTo(markers);
            marker.bindPopup(`
                <div class="text-center" style="width:150px">
                    <img src="${p.logo}" class="rounded-circle mb-2" style="width:50px; height:50px; object-fit:cover;">
                    <h6 class="mb-0 fw-bold">${p.nombre}</h6>
                    <small class="text-muted d-block mb-2">${p.ubi}</small>
                    <a href="${p.url}" class="btn btn-primary btn-sm rounded-pill text-white w-100">Ver Perfil</a>
                </div>
            `);
        }
    });

    markers.addTo(map);
    if(puntos.length > 0) map.fitBounds(markers.getBounds().pad(0.1));
</script>
@endsection