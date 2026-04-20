@extends('layouts.layout')
@section('title', 'Mi Panel - Cliente')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Hola, {{ Auth::user()->nombre }}</h2>
            <div class="alert alert-info">
                Has iniciado sesión como <strong>Cliente</strong>.
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Comercios</h4>
                <p>Explora tiendas cercanas.</p>
                <button class="btn btn-outline-primary">Ver tiendas</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Mis Reservas</h4>
                <p>Gestiona tus pedidos activos.</p>
                <button class="btn btn-outline-primary">Ver reservas</button>
            </div>
        </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Productos favoritos</h4>
                <p>Échale un ojo a tus productos favoritos.</p>
                <button class="btn btn-outline-primary">Ver favoritos</button>
            </div>
        </div>
    </div>
</div>
@endsection
