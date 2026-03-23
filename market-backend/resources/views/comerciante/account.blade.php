@extends('layouts.layout')
@section('title', 'Mi Negocio - Comerciante')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Panel de Control de tu Negocio</h2>
            <div class="alert alert-success">
                Bienvenido, {{ Auth::user()->nombre }}. Estás en tu perfil de <strong>Comerciante</strong>.
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Mis Productos</h4>
                <p>Añade o edita tu catálogo.</p>
                <button class="btn btn-success">Gestionar</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Mi Ubicación</h4>
                <p>Actualiza dónde estás hoy.</p>
                <button class="btn btn-success">Actualizar</button>
            </div>
        </div>
    </div>
</div>
@endsection