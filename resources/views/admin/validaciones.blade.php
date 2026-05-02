@extends('layouts.layout')
@section('title', 'Administración - Market Manager')
@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Panel de Validación de Comercios</h2>

    @if(session('success'))
        <div class="alert alert-success rounded-pill shadow-sm border-0 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($pendientes as $negocio)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0" style="border-radius: 24px; transition: transform 0.3s ease;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-shop"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title mb-0 fw-bold">{{ $negocio->nombre_negocio }}</h5>
                                <small class="text-muted">Solicitado por: {{ $negocio->user->name }}</small>
                            </div>
                        </div>

                        <p class="card-text text-secondary">{{ Str::limit($negocio->descripcion, 100) }}</p>
                        
                        <ul class="list-unstyled small mb-4">
                            <li><strong>NIF:</strong> {{ $negocio->nif }}</li>
                            <li><strong>Permiso:</strong> #{{ $negocio->numero_permiso }}</li>
                        </ul>

                        <div class="d-flex gap-2">
                            <form action="{{ route('admin.aprobar', $negocio->id) }}" method="POST" class="w-100">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 rounded-pill shadow-sm py-2">
                                    Aprobar
                                </button>
                            </form>

                            <form action="{{ route('admin.rechazar', $negocio->id) }}" method="POST" class="w-100">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2">
                                    Rechazar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">No hay comercios pendientes de validación por ahora. 🙌</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    /* El efecto hover que querías */
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection