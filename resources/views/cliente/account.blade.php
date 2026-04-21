@extends('layouts.layout')
@section('title', 'Mi Panel - Cliente')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
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
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Notificaciones</h4>
                <p>Mira tus notificaciones.</p>
                <button class="btn btn-outline-primary">Ver notificaciones</button>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Foros</h4>
                <p>Navega en los foros con otros usuarios.</p>
                <button class="btn btn-outline-primary">Ver foros</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Productos favoritos</h4>
                <p>Échale un ojo a tus productos favoritos.</p>
                <button class="btn btn-outline-primary">Ver favoritos</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4>Mi cuenta</h4>
                <p>Edita tu cuenta.</p>
                <a href="{{ route('profile.edit') }}" class="btn w-100 rounded-pill fw-bold py-2" style="background-color: rgba(108, 117, 125, 0.1); color: #6c757d; border: none;">Editar Perfil</a>
            </div>
        </div>
    </div>
</div>
@endsection
