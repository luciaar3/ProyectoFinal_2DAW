@extends('layouts.layout')
@section('title', 'Administración - Market Manager')
@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Panel de Administración</h2>
    
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 admin-card" style="border-radius: 24px;">
                <div class="card-body p-4 text-center">
                    <div class="icon-circle bg-warning bg-opacity-10 text-warning mb-3 mx-auto">
                        <i class="bi bi-shop fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Validaciones</h5>
                    <p class="text-muted small">Tienes <strong>{{ $totalPendientes }}</strong> comercios esperando aprobación.</p>
                    <a href="{{ route('admin.validaciones') }}" class="btn btn-warning rounded-pill px-4 shadow-sm w-100">
                        Revisar ahora
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 admin-card" style="border-radius: 24px;">
                <div class="card-body p-4 text-center">
                    <div class="icon-circle bg-primary bg-opacity-10 text-primary mb-3 mx-auto">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Usuarios</h5>
                    <p class="text-muted small">Total de usuarios registrados: <strong>{{ $totalUsuarios }}</strong></p>
                    <button class="btn btn-primary rounded-pill px-4 shadow-sm w-100" disabled>
                        Ver listado
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 admin-card" style="border-radius: 24px;">
                <div class="card-body p-4 text-center">
                    <div class="icon-circle bg-danger bg-opacity-10 text-danger mb-3 mx-auto">
                        <i class="bi bi-exclamation-triangle fs-3"></i>
                    </div>
                    <h5 class="fw-bold">Moderación</h5>
                    <p class="text-muted small">Denuncias activas en foros: <strong>{{ $totalDenuncias }}</strong></p>
                    <button class="btn btn-danger rounded-pill px-4 shadow-sm w-100" disabled>
                        Ver reportes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-card {
        transition: transform 0.3s ease;
    }
    .admin-card:hover {
        transform: translateY(-5px);
    }
    .icon-circle {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
</style>
@endsection