@extends('layouts.layout')

@section('title', __('foro.title', ['puesto' => $negocio->nombre_negocio]))

@section('content')
<div class="container mt-5 pt-4 mb-5">
    <div class="row mb-5 align-items-center bg-white p-4 p-md-5 shadow-sm" style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.05);">
        <div class="col-md-auto text-center mb-3 mb-md-0">
            <img src="{{ $negocio->imagen ? asset('storage/' . $negocio->imagen) : 'https://via.placeholder.com/100' }}" 
                 class="rounded-circle shadow-sm border border-3" 
                 style="width: 100px; height: 100px; object-fit: cover; border-color: rgba(245, 48, 3, 0.2) !important;">
        </div>
        <div class="col-md">
            <span class="badge mb-1 text-white px-3 py-1 rounded-pill" style="background-color: #f53003; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">{{ __('foro.badge_community') }}</span>
            <h1 class="fw-bolder text-dark mb-1" style="letter-spacing: -0.5px;">{{ $negocio->nombre_negocio }}</h1>
            <p class="text-secondary mb-0"><i class="bi bi-info-circle me-2 text-muted"></i>{{ __('foro.subtitle') }}</p>
        </div>
        <div class="col-md-auto mt-3 mt-md-0 d-flex gap-2 flex-wrap">
            <a href="{{ url()->previous() == url()->current() ? route('foros.index') : url()->previous() }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>{{ __('foro.btn_back') }}
            </a>
            <a href="{{ route('foros.index') }}" class="btn rounded-pill px-4 fw-bold shadow-sm text-white" style="background-color: #f53003; border: none;">
                <i class="bi bi-grid-fill me-2"></i>{{ __('foro.btn_view_all') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bolder text-dark mb-0" style="letter-spacing: -0.5px;">
                    <i class="bi bi-chat-left-text-fill me-2" style="color: #f53003;"></i>{{ __('foro.section_title') }}
                </h3>
                <a href="#nueva-pregunta-seccion" class="btn btn-light rounded-pill fw-bold text-dark px-3 border shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> {{ __('foro.new_question') }}
                </a>
            </div>
            
            @forelse($negocio->foros as $mensaje)
                @php 
                    $preguntaEsComerciante = ($mensaje->user_id == $negocio->user_id); 
                @endphp

                <div class="card mb-4 border-0 shadow-sm" style="border-radius: 24px; {{ $preguntaEsComerciante ? 'border-left: 6px solid #2e7d32 !important; background-color: #fbfdfc;' : '' }}">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="text-white rounded-circle d-flex justify-content-center align-items-center fw-bold me-3 shadow-sm" 
                                     style="width: 52px; height: 52px; font-size: 1.2rem; {{ $preguntaEsComerciante ? 'background: linear-gradient(135deg, #2e7d32, #43a047);' : 'background-color: #f53003;' }}">
                                    @if($preguntaEsComerciante)
                                        <i class="bi bi-shop"></i>
                                    @else
                                        {{ strtoupper(substr($mensaje->usuario->nombre, 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold {{ $preguntaEsComerciante ? 'text-success' : 'text-dark' }}">
                                        {{ $mensaje->usuario->nombre }}
                                        @if($preguntaEsComerciante)
                                            <span class="badge rounded-pill bg-success ms-2 text-white fw-bold shadow-sm" style="font-size: 0.65rem; padding: 4px 9px;">
                                                <i class="bi bi-patch-check-fill me-1"></i> {{ __('foro.merchant_badge') }}
                                            </span>
                                        @endif
                                    </h5>
                                    <small class="text-muted d-flex align-items-center"><i class="bi bi-clock me-1"></i>{{ $mensaje->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @if($mensaje->user_id === auth()->id())
                                <span class="badge bg-light text-dark border border-2 rounded-pill px-3 py-2 fw-bold" style="font-size: 0.75rem;">{{ __('foro.asked_by') }}</span>
                            @endif
                        </div>
                        
                        <h4 class="fw-bolder text-dark mb-2 mt-2" style="letter-spacing: -0.3px;">{{ $mensaje->titulo }}</h4>
                        <p class="text-secondary mb-4 fs-6" style="white-space: pre-line; line-height: 1.6; max-width: 900px;">{{ $mensaje->contenido }}</p>
                        
                        @if($mensaje->respuestas->count() > 0)
                            <div class="ps-2 ps-md-4 border-start border-3 mt-4" style="border-color: rgba(245, 48, 3, 0.15) !important;">
                                <div class="text-muted small fw-bold mb-3 text-uppercase tracking-wider" style="font-size: 0.75rem; letter-spacing: 0.5px;">{{ __('foro.view_replies') }}</div>
                                
                                @foreach($mensaje->respuestas as $respuesta)
                                    @php 
                                        $respuestaEsComerciante = ($respuesta->user_id == $negocio->user_id); 
                                    @endphp
                                    
                                    <div class="d-flex mb-3 align-items-start" style="max-width: 950px;">
                                        <div class="rounded-circle d-flex justify-content-center align-items-center fw-bold me-3 shadow-sm flex-shrink-0" 
                                             style="width: 42px; height: 42px; font-size: 0.95rem; {{ $respuestaEsComerciante ? 'background: linear-gradient(135deg, #2e7d32, #43a047); color: white;' : 'background-color: #f8f9fa; color: #212529; border: 1px solid #e0e0e0;' }}">
                                            @if($respuestaEsComerciante)
                                                <i class="bi bi-shop"></i>
                                            @else
                                                {{ strtoupper(substr($respuesta->usuario->nombre, 0, 1)) }}
                                            @endif
                                        </div>

                                        <div class="p-3 px-4 rounded-4 flex-grow-1 shadow-sm position-relative" 
                                             style="border-top-left-radius: 0px; 
                                             {{ $respuestaEsComerciante 
                                                ? 'background-color: #f1f9f5; border-left: 5px solid #2e7d32 !important; border: 1px solid rgba(46, 125, 50, 0.12);' 
                                                : 'background-color: #f8f9fa; border: 1px solid rgba(0,0,0,0.03);' 
                                             }}">
                                            
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <span class="fw-bold {{ $respuestaEsComerciante ? 'text-success' : 'text-dark' }}">
                                                        {{ $respuesta->usuario->nombre }} 
                                                    </span>
                                                    @if($respuestaEsComerciante)
                                                        <span class="badge rounded-pill bg-success ms-2 text-white fw-bold shadow-sm d-inline-flex align-items-center" style="font-size: 0.65rem; padding: 4px 9px; letter-spacing: 0.3px;">
                                                            <i class="bi bi-patch-check-fill me-1"></i> {{ __('foro.merchant_badge') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i>{{ $respuesta->created_at->diffForHumans() }}</small>
                                            </div>
                                            
                                            <p class="mb-0 mt-1 {{ $respuestaEsComerciante ? 'text-dark fw-medium' : 'text-secondary' }}" style="white-space: pre-line; line-height: 1.5; font-size: 0.95rem;">{{ $respuesta->contenido }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-4">
                            <button class="btn btn-link p-0 text-decoration-none fw-bold small d-flex align-items-center" 
                                    type="button" data-bs-toggle="collapse" data-bs-target="#replyForm{{ $mensaje->id }}" 
                                    style="color: #f53003; font-size: 0.9rem;">
                                <i class="bi bi-reply-all-fill fs-5 me-1"></i> {{ __('foro.reply_thread') }}
                            </button>
                            
                            <div class="collapse mt-3" id="replyForm{{ $mensaje->id }}">
                                <form action="{{ route('foros.store') }}" method="POST" class="p-3 bg-light rounded-4 border" style="max-width: 700px;">
                                    @csrf
                                    <input type="hidden" name="negocio_id" value="{{ $negocio->id }}">
                                    <input type="hidden" name="parent_id" value="{{ $mensaje->id }}">
                                    <input type="hidden" name="titulo" value="Re: {{ $mensaje->titulo }}">
                                    
                                    <textarea name="contenido" class="form-control border-0 bg-white py-3 mb-2 shadow-sm" rows="2" placeholder="{{ __('foro.reply_placeholder') }}" required style="border-radius: 12px; font-size: 0.95rem;"></textarea>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-sm px-4 py-2 fw-bold text-white shadow-sm" style="background-color: #f53003; border-radius: 12px;">
                                            {{ __('foro.btn_reply') }} <i class="bi bi-send-fill small ms-1"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-white shadow-sm mb-5" style="border-radius: 24px; border: 1px solid rgba(0,0,0,0.05);">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 80px; height: 80px; background-color: #e8f3ee; color: #2e7d32;">
                        <i class="bi bi-chat-square-dots fs-1"></i>
                    </div>
                    <p class="text-secondary fw-bold fs-5 mb-1">{{ __('foro.no_questions') }}</p>
                </div>
            @endforelse

            <hr class="my-5 opacity-25" id="nueva-pregunta-seccion">

            <div class="card border-0 shadow-sm col-xl-8 mx-auto" style="border-radius: 24px;">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2 rounded-3 me-3" style="background-color: rgba(245, 48, 3, 0.1); color: #f53003;">
                            <i class="bi bi-pencil-square fs-3"></i>
                        </div>
                        <div>
                            <h4 class="fw-bolder text-dark mb-0" style="letter-spacing: -0.5px;">{{ __('foro.new_question') }}</h4>
                            <p class="text-muted small mb-0">{{ __('foro.form_helper') }}</p>
                        </div>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success border-0 text-success shadow-sm d-flex align-items-center mb-4" style="border-radius: 14px; background-color: #e8f3ee;">
                            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                            <div class="fw-medium small">{{ session('success') }}</div>
                        </div>
                    @endif

                    <form action="{{ route('foros.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="negocio_id" value="{{ $negocio->id }}">
                        
                        <div class="mb-3">
                            <label for="titulo" class="form-label fw-bold text-dark small">{{ __('foro.field_title') }}</label>
                            <input type="text" class="form-control bg-light border-0 py-3 px-3" id="titulo" name="titulo" placeholder="{{ __('foro.field_title_placeholder') }}" required style="border-radius: 14px; font-size: 0.95rem;">
                        </div>

                        <div class="mb-4">
                            <label for="contenido" class="form-label fw-bold text-dark small">{{ __('foro.field_message') }}</label>
                            <textarea class="form-control bg-light border-0 py-3 px-3" id="contenido" name="contenido" rows="4" placeholder="{{ __('foro.field_message_placeholder') }}" required style="border-radius: 14px; font-size: 0.95rem;"></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn text-white fw-bold shadow-sm px-5 py-3" style="background-color: #f53003; border-radius: 16px; font-size: 1rem;">
                                {{ __('foro.btn_send') }} <i class="bi bi-send-fill ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection