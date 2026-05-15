@extends('layouts.layout')
@section('title', 'Notificaciones')
@section('content')
<div class="container mt-5">
    <!-- Título -->
    <div class="row justify-content-center mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Notificaciones recientes</h2>
            <a href="{{ Auth::user()->rol === 'Cliente' ? route('cliente.account') : (Auth::user()->rol === 'Comerciante' ? route('comerciante.account') : route('admin.account')) }}" class="btn btn-outline-secondary rounded-pill">Volver al Panel</a>
        </div>
        <div class="col-12">
            <div class="alert alert-info">
                Aquí puedes ver y gestionar tus notificaciones.
            </div>
        </div>
    </div>
    <!-- LISTADO -->
    <div class="row g-4">
        @forelse ($notificaciones as $notificacion)
            <div class="col-md-4">
                <div class="card shadow-sm text-center p-3 h-100">
                    <h4>{{ $notificacion->titulo }}</h4>
                    <p class="text-muted">{{ $notificacion->mensaje }}</p>
                    <form action="{{ route('notificaciones.destroy', $notificacion) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            Eliminar
                        </button>
                    </form>

                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="alert alert-secondary">
                    No hay notificaciones
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
