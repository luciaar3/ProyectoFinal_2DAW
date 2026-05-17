@extends('layouts.layout')

@section('content')
<style>
    .bg-soft-sage { background-color: #f0f2ef; }
    .text-sage { color: #4a5d4e; }
    .table thead th { font-size: 0.8rem; letter-spacing: 0.5px; border: none; }
    .transition-back { transition: transform 0.2s ease, opacity 0.2s ease; }
    .transition-back:hover { transform: translateX(-4px); opacity: 0.85; }
</style>

<div class="container mb-5" style="padding-top: 50px;">
    
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('comerciante.account') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-2 fw-semibold transition-back">
                <i class="bi bi-arrow-left fs-5"></i> {{ __('bookings.btn_back') ?? 'Volver al panel' }}
            </a>
        </div>
    </div>

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">{{ __('bookings.title') }}</h2>
            <p class="text-muted mb-0 small">{{ __('bookings.subtitle', ['business' => $negocio->nombre_negocio]) }}</p>
        </div>
        <span class="badge rounded-pill px-3 py-2 fw-bold" style="background-color: #eceff1; color: #37474f; font-size: 0.85rem;">
            {{ $reservas->count() }} {{ __('bookings.total_count') }}
        </span>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 24px; overflow: hidden; border: 1px solid rgba(0,0,0,0.03) !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3 fw-bold">{{ __('bookings.col_client') }}</th>
                            <th class="py-3 fw-bold">{{ __('bookings.col_product') }}</th>
                            <th class="py-3 fw-bold">{{ __('bookings.col_options') }}</th>
                            <th class="py-3 text-center fw-bold">{{ __('bookings.col_quantity') }}</th>
                            <th class="py-3 fw-bold">{{ __('bookings.col_total') }}</th>
                            <th class="py-3 fw-bold">{{ __('bookings.col_pickup') }}</th>
                            <th class="py-3 fw-bold">{{ __('bookings.col_status') }}</th>
                            <th class="py-3 pe-4 fw-bold text-end">{{ __('bookings.col_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservas as $reserva)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $reserva->user->name }}</div>
                                    <div class="small text-muted">{{ $reserva->user->email }}</div>
                                </td>
                                <td class="fw-semibold text-dark">{{ $reserva->producto->nombre }}</td>
                                <td>
                                    @if($reserva->variante_elegida && $reserva->variante_elegida !== 'Sin variantes')
                                        <span class="badge bg-soft-sage text-sage border-0 px-2.5 py-1.5 rounded">
                                            {{ $reserva->variante_elegida }}
                                        </span>
                                    @else
                                        <span class="text-muted small fst-italic">{{ __('bookings.variant_standard') }}</span>
                                    @endif
                                </td>
                                <td class="text-center fw-bold text-secondary">{{ $reserva->cantidad }}</td>
                                <td class="fw-bolder text-dark">{{ number_format($reserva->coste_total, 2, ',', '.') }}€</td>
                                <td>
                                    @if($reserva->lugarRecogida)
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                            {{ $reserva->lugarRecogida->ubicacion }}
                                        </div>
                                        <small class="text-muted d-block" style="font-size: 0.8rem;">
                                            {{ $reserva->lugarRecogida->poblacion }} — <span class="text-sage fw-semibold text-capitalize">{{ __("bookings.days.{$reserva->lugarRecogida->dia}") }}</span>
                                        </small>
                                    @else
                                        <span class="text-muted small fst-italic">{{ __('bookings.no_pickup_specified') }}</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge rounded-pill px-3 py-1.5 fw-bold
                                        {{ $reserva->estado == 'pendiente' ? 'bg-warning text-dark' : '' }}
                                        {{ $reserva->estado == 'completada' ? 'bg-success text-white' : '' }}
                                        {{ $reserva->estado == 'cancelada' ? 'bg-danger text-white' : '' }}">
                                        {{ __('bookings.status_' . $reserva->estado) }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle rounded-pill px-3 fw-semibold" style="font-size: 0.8rem;" data-bs-toggle="dropdown">
                                            <i class="bi bi-sliders2 me-1"></i> {{ __('bookings.btn_manage') }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 16px;">
                                            <li>
                                                <form action="{{ route('reservas.actualizarEstado', $reserva->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="completada">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center py-2 fw-medium">
                                                        <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i> {{ __('bookings.action_complete') }}
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('reservas.actualizarEstado', $reserva->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="pendiente">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center py-2 fw-medium">
                                                        <i class="bi bi-clock-history text-warning me-2 fs-5"></i> {{ __('bookings.action_revert') }}
                                                    </button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider opacity-50"></li>
                                            <li>
                                                <form action="{{ route('reservas.actualizarEstado', $reserva->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="estado" value="cancelada">
                                                    <button type="submit" class="dropdown-item d-flex align-items-center py-2 text-danger fw-medium">
                                                        <i class="bi bi-x-circle-fill me-2 fs-5"></i> {{ __('bookings.action_cancel') }}
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted fst-italic">
                                    <i class="bi bi-calendar-x d-block fs-1 mb-2 opacity-50"></i>
                                    {{ __('bookings.empty_list') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection