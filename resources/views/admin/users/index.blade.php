@extends('layouts.layout')

@section('title', 'Listado de Usuarios - Administración')

@section('content')
<div class="container mt-5 pt-4 mb-5">
    
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 py-1" style="background: transparent;">
                <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none fw-medium text-secondary hover-link">Inicio</a></li>
                <li class="breadcrumb-item"><a href="#" onclick="window.history.back();" class="text-decoration-none fw-medium text-secondary hover-link">Panel Admin</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page" style="color: #f53003;">Usuarios</li>
            </ol>
        </nav>
        
        <button onclick="window.history.back();" class="btn btn-light rounded-pill px-3 py-2 btn-volver border d-flex align-items-center gap-2 bg-white text-secondary small fw-bold shadow-sm">
            <i class="bi bi-arrow-left fs-6 text-dark"></i> Volver al Panel
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 24px;">
        <div class="card-body p-4 p-md-5">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h3 class="fw-bolder text-dark mb-1" style="letter-spacing: -1px;">Control de Usuarios</h3>
                    <p class="text-secondary small mb-0">Visualiza y gestiona las cuentas registradas en MercaZone.</p>
                </div>
                <span class="badge rounded-pill px-3 py-2 align-self-start align-self-md-center" style="background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; font-weight: 600; font-size: 0.9rem;">
                    {{ $users->total() }} Cuentas en total
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0 8px;">
                    <thead>
                        <tr class="text-secondary small fw-bold" style="border-bottom: 2px solid #f8f9fa;">
                            <th class="ps-3" style="width: 80px;">Inicial</th>
                            <th>Nombre Completo</th>
                            <th>Correo Electrónico</th>
                            <th>Rol asignado</th>
                            <th>Fecha Registro</th>
                            <th class="text-end pe-3" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                            <tr class="bg-white shadow-sm-hover" style="border-radius: 16px; transition: all 0.2s;">
                                <td class="ps-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold shadow-inner" 
                                         style="width: 40px; height: 40px; background-color: rgba(245, 48, 3, 0.06); color: #f53003; font-size: 0.95rem;">
                                        {{ substr($u->nombre, 0, 1) }}
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="fw-bold text-dark">{{ $u->nombre }}</div>
                                    <div class="text-muted small">{{ $u->primer_apellido }} {{ $u->segundo_apellido }}</div>
                                </td>
                                
                                <td class="text-secondary font-monospace small">
                                    {{ $u->email }}
                                </td>
                                
                                <td>
                                    @if($u->rol === 'Admin')
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545; font-weight: 600;">Administrador</span>
                                    @elseif($u->rol === 'Comerciante')
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(245, 48, 3, 0.1); color: #f53003; font-weight: 600;">Comerciante</span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; font-weight: 600;">Cliente</span>
                                    @endif
                                </td>
                                
                                <td class="text-muted small pe-3">
                                    {{ $u->created_at ? $u->created_at->format('d/m/Y') : 'Desconocida' }}
                                </td>

                                <td class="text-end pe-3">
                                    @if($u->id !== Auth::user()->id)
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar permanentemente a este usuario?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">Tú (Admin)</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2 opacity-50"></i>
                                    No hay ningún usuario registrado todavía.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>

<style>
    .shadow-inner {
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.03);
    }
    .hover-link:hover {
        color: #f53003 !important;
    }
    .btn-volver:hover {
        background-color: #f8f9fa !important;
        color: #f53003 !important;
        transform: translateX(-2px);
        transition: all 0.2s ease;
    }
    /* Efecto sutil al pasar el ratón por encima de las filas de la tabla */
    .shadow-sm-hover:hover {
        background-color: #fafafa !important;
    }
    table th {
        border-bottom: none !important;
    }
</style>
@endsection