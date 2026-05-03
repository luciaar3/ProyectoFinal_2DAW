@extends('layouts.layout')

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
                    <a href="{{ route('negocios.index') }}" class="btn btn-outline-primary">Ver tiendas</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center p-3">
                    <h4>Mis Reservas</h4>
                    <p>Gestiona tus pedidos activos.</p>
                    <a href="{{ route('cliente.reservas') }}" class="btn btn-outline-primary">Ver reservas</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center p-3">
                    <h4>Notificaciones</h4>
                    <p>Mira tus notificaciones.</p>
                    <a href="{{ route('notificationes.index') }}" class="btn btn-outline-primary">Ver notificaciones</a>
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
                    <h4>Productos Favoritos</h4>
                    <p>Accede a los productos que más te gustan.</p>
                    <a href="{{ route('cliente.favoritos') }}" class="btn btn-outline-primary">Ver favoritos</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm text-center p-3">
                    <h4>Mi cuenta</h4>
                    <p>Edita tu cuenta.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">Editar Perfil</a>
                </div>
            </div>
        </div>
    </div>
@endsection