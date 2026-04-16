@extends('layouts.layout')
@section('title', 'Administración - Market Manager')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Panel de Administración</h2>
            <div class="alert alert-dark">
                Acceso nivel: <strong>Administrador del sistema</strong>.
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Usuarios</h4>
                <p>Gestiona clientes y comerciantes.</p>
                <button class="btn btn-dark">Ver todos</button>
            </div>
        </div>
    </div>
</div>
@endsection