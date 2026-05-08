@extends('layouts.layout')

@section('content')
<div class="container" style="padding-top: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Gestión de Reservas</h2>
            <p class="text-muted">Administra los pedidos de {{ $negocio->nombre_negocio }}</p>
        </div>
        <span class="badge bg-dark px-3 py-2 rounded-pill">{{ $reservas->count() }} Reservas totales</span>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Cliente</th>
                            <th class="py-3">Producto</th>
                            <th class="py-3">Opciones (Variantes)</th>
                            <th class="py-3 text-center">Cantidad</th>
                            <th class="py-3">Total</th>
                            <th class="py-3">Estado</th>
                            <th class="py-3 pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservas as $reserva)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $reserva->user->name }}</div>
                                    <div class="small text-muted">{{ $reserva->user->email }}</div>
                                </td>
                                <td>{{ $reserva->producto->nombre }}</td>
                                <td>
                                    @if($reserva->variante_elegida && $reserva->variante_elegida !== 'Sin variantes')
                                        <span class="badge bg-soft-sage text-sage border">
                                            {{ $reserva->variante_elegida }}
                                        </span>
                                    @else
                                        <span class="text-muted small italic">Estándar</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $reserva->cantidad }}</td>
                                <td class="fw-bold">{{ number_format($reserva->coste_total, 2) }}€</td>
                                <td>
                                    <span class="badge rounded-pill 
                                        {{ $reserva->estado == 'pendiente' ? 'bg-warning text-dark' : '' }}
                                        {{ $reserva->estado == 'completada' ? 'bg-success' : '' }}
                                        {{ $reserva->estado == 'cancelada' ? 'bg-danger' : '' }}">
                                        {{ ucfirst($reserva->estado) }}
                                    </span>
                                </td>
                                <td class="pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle rounded-pill" data-bs-toggle="dropdown">
                                            Gestionar
                                        </button>
                                        <ul class="dropdown-menu shadow border-0" style="border-radius: 15px;">
                                            {{-- Opción Completar --}}
                                            <li>
                                                <form action="{{ route('reservas.actualizarEstado', $reserva->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="completada">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center py-2">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i> Marcar como Completada
                                                    </button>
                                                </form>
                                            </li>

                                            {{-- Opción Pendiente (por si quieres volver atrás) --}}
                                            <li>
                                                <form action="{{ route('reservas.actualizarEstado', $reserva->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="pendiente">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center py-2">
                                                        <i class="bi bi-clock-history text-warning me-2"></i> Devolver a Pendiente
                                                    </button>
                                                </form>
                                            </li>

                                            <li><hr class="dropdown-divider"></li>

                                            {{-- Opción Cancelar --}}
                                            <li>
                                                <form action="{{ route('reservas.actualizarEstado', $reserva->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="cancelada">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center py-2 text-danger">
                                                        <i class="bi bi-x-circle-fill me-2"></i> Cancelar Reserva
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    No hay reservas registradas todavía.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-sage { background-color: #f0f2ef; }
    .text-sage { color: #4a5d4e; }
    .table thead th { font-size: 0.8rem; letter-spacing: 0.5px; border: none; }
</style>
@endsection