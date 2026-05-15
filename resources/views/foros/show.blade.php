@extends('layouts.layout')

@section('title', 'Foro - ' . $negocio->nombre_negocio)

@section('content')
<div class="container py-5">
    <!-- Header del Foro -->
    <div class="row mb-5 align-items-center bg-white p-4 shadow-sm" style="border-radius: 20px;">
        <div class="col-md-auto text-center mb-3 mb-md-0">
            <img src="{{ $negocio->imagen ? asset('storage/' . $negocio->imagen) : 'https://via.placeholder.com/100' }}" 
                 class="rounded-circle shadow-sm" 
                 style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #7b52d9;">
        </div>
        <div class="col-md">
            <h1 class="fw-bold mb-1">{{ $negocio->nombre_negocio }}</h1>
            <p class="text-muted mb-0"><i class="bi bi-info-circle me-2"></i>Foro oficial de la tienda para dudas y consultas.</p>
        </div>
        <div class="col-md-auto mt-3 mt-md-0">
            <a href="{{ route('foros.index') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-2"></i>Volver a Foros
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Listado de Mensajes -->
        <div class="col-lg-8">
            <h3 class="mb-4 fw-bold"><i class="bi bi-chat-left-text me-2" style="color: #7b52d9;"></i>Conversaciones</h3>
            
            @forelse($negocio->foros as $mensaje)
                <div class="card mb-4 border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center fw-bold me-3" style="width: 45px; height: 45px; background-color: #7b52d9 !important;">
                                    {{ strtoupper(substr($mensaje->usuario->nombre, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $mensaje->usuario->nombre }}</h6>
                                    <small class="text-muted">{{ $mensaje->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @if($mensaje->user_id === auth()->id())
                                <span class="badge bg-light text-primary border rounded-pill px-3 py-2">Tú</span>
                            @endif
                        </div>
                        <h5 class="fw-bold text-dark">{{ $mensaje->titulo }}</h5>
                        <p class="text-muted" style="white-space: pre-line;">{{ $mensaje->contenido }}</p>
                        
                        <hr class="my-3 opacity-25">
                        
                        <!-- Respuestas -->
                        @if($mensaje->respuestas->count() > 0)
                            <div class="ms-4 ms-md-5 mt-4">
                                @foreach($mensaje->respuestas as $respuesta)
                                    <div class="d-flex mb-3">
                                        <div class="bg-light text-dark rounded-circle d-flex justify-content-center align-items-center fw-bold me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                            {{ strtoupper(substr($respuesta->usuario->nombre, 0, 1)) }}
                                        </div>
                                        <div class="bg-light p-3 rounded-4 flex-grow-1" style="border-top-left-radius: 0;">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="fw-bold small">{{ $respuesta->usuario->nombre }}</span>
                                                <small class="text-muted" style="font-size: 0.7rem;">{{ $respuesta->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="small mb-0" style="white-space: pre-line;">{{ $respuesta->contenido }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Botón y Formulario de Respuesta -->
                        <div class="mt-3">
                            <button class="btn btn-link p-0 text-decoration-none fw-bold small" type="button" data-bs-toggle="collapse" data-bs-target="#replyForm{{ $mensaje->id }}" style="color: #7b52d9;">
                                <i class="bi bi-reply me-1"></i> Responder
                            </button>
                            
                            <div class="collapse mt-3" id="replyForm{{ $mensaje->id }}">
                                <form action="{{ route('foros.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="negocio_id" value="{{ $negocio->id }}">
                                    <input type="hidden" name="parent_id" value="{{ $mensaje->id }}">
                                    <input type="hidden" name="titulo" value="Re: {{ $mensaje->titulo }}">
                                    
                                    <textarea name="contenido" class="form-control bg-light border-0 py-2 mb-2" rows="2" placeholder="Escribe tu respuesta..." required style="border-radius: 10px; font-size: 0.9rem;"></textarea>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-sm px-4 fw-bold shadow-sm" style="background-color: #7b52d9; color: white; border-radius: 10px;">
                                            Enviar <i class="bi bi-send small ms-1"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-white shadow-sm" style="border-radius: 15px;">
                    <i class="bi bi-chat-square-dots display-1 text-muted mb-3 d-block"></i>
                    <p class="text-muted fs-5">No hay mensajes todavía. ¡Sé el primero en preguntar!</p>
                </div>
            @endforelse
        </div>

        <!-- Formulario para Nuevo Mensaje -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="border-radius: 20px; top: 20px;">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4 text-center">Nueva Pregunta</h4>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-pill" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('foros.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="negocio_id" value="{{ $negocio->id }}">
                        
                        <div class="mb-3">
                            <label for="titulo" class="form-label fw-semibold">Asunto</label>
                            <input type="text" class="form-control bg-light border-0 py-2" id="titulo" name="titulo" placeholder="Ej: ¿Hay stock de manzanas?" required style="border-radius: 10px;">
                        </div>

                        <div class="mb-4">
                            <label for="contenido" class="form-label fw-semibold">Tu mensaje</label>
                            <textarea class="form-control bg-light border-0 py-2" id="contenido" name="contenido" rows="5" placeholder="Escribe aquí tu duda..." required style="border-radius: 10px;"></textarea>
                        </div>

                        <button type="submit" class="btn w-100 py-3 fw-bold shadow-sm" style="background-color: #7b52d9; color: white; border-radius: 15px; transition: all 0.3s;">
                            Publicar Mensaje <i class="bi bi-send ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
