@extends('layouts.layout')
@section('title', 'Notificaciones')
@section('content')
<div class="container mt-5">
    <!-- Título -->
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <h2 class="mb-3">Notificaciones recientes</h2>
            <div class="alert alert-info">
                Aquí puedes ver y gestionar tus notificaciones.
            </div>
        </div>
    </div>
    <!-- LISTADO -->
    <div class="row g-4">
        @forelse ($notificationes as $notification)
            <div class="col-md-4">
                <div class="card shadow-sm text-center p-3 h-100">
                    <h4>{{ $notification->titulo }}</h4>
                    <p class="text-muted">{{ $notification->mensaje }}</p>
                    <form action="{{ route('notificationes.destroy', $notification) }}" method="POST">
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
