@foreach($negocios as $negocio)
    <div class="card border-0 shadow-sm mb-4 card-negocio" 
         style="border-radius: 24px; transition: transform 0.3s ease;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img src="{{ $negocio->imagen ? asset('storage/'.$negocio->imagen) : asset('img/default-shop.png') }}" 
                         class="rounded-circle shadow-sm" 
                         style="width: 70px; height: 70px; object-fit: cover; border: 3px solid #f8f9fa;">
                </div>
                
                <div class="flex-grow-1 ms-3">
                    <h5 class="fw-bold mb-1 text-dark">{{ $negocio->nombre_negocio }}</h5>
                    <p class="text-muted small mb-2">
                        <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                        {{-- Acceso a relación Horarios --}}
                        @php $horarioActual = $negocio->horarios->where('dia', $diaFiltro)->first(); @endphp
                        {{ $horarioActual->Ciudad ?? 'Ubicación no disponible' }}
                    </p>
                    <a href="{{ route('negocios.show', $negocio->id) }}" 
                       class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                        Ver Puesto
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach

<style>
    .card-negocio:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>