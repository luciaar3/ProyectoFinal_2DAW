@extends('layouts.layout')

@section('title', 'Inicio - Market Manager')

@section('content')
<style>
    body {
        background: #ffffff;
        background-image: 
            radial-gradient(circle at 10% 20%, rgba(123, 82, 217, 0.05) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(0, 210, 255, 0.05) 0%, transparent 40%);
    }

    /*Contenedor de la Tarjeta Giratoria */
    .flip-card {
        background-color: transparent;
        height: 420px;
        perspective: 1000px; /* Le da el efecto de profundidad 3D */
    }

    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.8s cubic-bezier(0.4, 0.2, 0.2, 1);
        transform-style: preserve-3d;
    }

    /* Al pasar el ratón, la tarjeta gira 180 grados */
    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    /*Caras de la Tarjeta */
    .flip-card-front, .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        border: 1px solid #f0f0f0;
        overflow: hidden;
    }

    /* Parte Delantera */
    .flip-card-front {
        background-color: #ffffff;
        display: flex;
        flex-direction: column;
    }

    .card-header-front { padding: 24px 24px 10px 24px; text-align: left; }
    
    .zen-graphic {
        height: 200px;
        margin-top: auto;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .zen-blob-1, .zen-blob-2 {
        position: absolute;
        border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
    }

    /* Parte Trasera*/
    .flip-card-back {
        background-color: #ffffff;
        transform: rotateY(180deg);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        text-align: center;
    }

    /* --- Destacar la Tarjeta Central --- */
    @media (min-width: 992px) {
        .card-destacada .flip-card {
            height: 460px; /* Las normales miden 420px, esta es 40px más alta */
            margin-top: -20px; /* La desplazamos un poco hacia arriba para que sobresalga */
            z-index: 10;
        }
        
        /* Mantenemos el borde morado y la sombra más fuerte */
        .card-destacada .flip-card-front, .card-destacada .flip-card-back {
            box-shadow: 0 20px 50px rgba(123, 82, 217, 0.15);
            border: 2px solid #7b52d9;
        }
        /* Ajuste para qu al girar no pierda el tamaño grande */
        .card-destacada:hover .flip-card-inner {
            transform: rotateY(180deg);
        }
        .card-destacada .flip-card-front, .card-destacada .flip-card-back {
            box-shadow: 0 20px 50px rgba(123, 82, 217, 0.15);
            border: 2px solid #7b52d9;
        }
    }

    /*colores de las burbujas */
    .zen-purple .zen-blob-1 { width: 140%; height: 140%; bottom: -50%; background: radial-gradient(circle, #b388ff 0%, #7b52d9 80%); }
    .zen-purple .zen-blob-2 { width: 80%; height: 120%; bottom: -30%; background: radial-gradient(circle, #00d2ff 0%, #3a7bd5 100%); opacity: 0.8; }
    
    .zen-green .zen-blob-1 { width: 140%; height: 140%; bottom: -50%; background: radial-gradient(circle, #81c784 0%, #388e3c 80%); }
    .zen-green .zen-blob-2 { width: 80%; height: 120%; bottom: -30%; background: radial-gradient(circle, #a1ffce 0%, #faffd1 100%); opacity: 0.8; }

    .zen-blue .zen-blob-1 { width: 140%; height: 140%; bottom: -50%; background: radial-gradient(circle, #64b5f6 0%, #1976d2 80%); }
    .zen-blue .zen-blob-2 { width: 80%; height: 120%; bottom: -30%; background: radial-gradient(circle, #00c6ff 0%, #0072ff 100%); opacity: 0.8; }
</style>

<div class="container text-center mt-5 pt-4 mb-5 pb-5">
    
    <h1 class="display-4 fw-bolder text-dark mb-3" style="letter-spacing: -1px;">
        Digitaliza y Conecta tu Comercio Local
    </h1>
    <p class="fs-5 text-secondary mx-auto mb-5" style="max-width: 800px; font-weight: 400;">
        Market Manager es la plataforma definitiva que une a los clientes con las tiendas de su barrio. 
        Descubre productos cerca de ti o gestiona el inventario de tu negocio desde un solo lugar.
    </p>

    <div class="row g-4 mt-4 justify-content-center align-items-center">
        
        <div class="col-lg-4 col-md-6 z-1">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <div class="card-header-front">
                            <h5 class="fw-bold mb-1 fs-4 text-dark">Para Clientes</h5>
                            <p class="text-secondary small">Explora y descubre las tiendas de tu ciudad.</p>
                        </div>
                        <div class="zen-graphic zen-blue bg-light">
                            <div class="zen-blob-1"></div><div class="zen-blob-2"></div>
                            <i class="bi bi-search text-white position-relative z-3" style="font-size: 5rem; filter: drop-shadow(0px 4px 10px rgba(0,0,0,0.2));"></i>
                        </div>
                    </div>
                    <div class="flip-card-back bg-light">
                        <i class="bi bi-geo-alt fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold text-dark">Encuentra lo que buscas</h5>
                        <p class="text-secondary">Busca productos, compara comercios, guarda tus tiendas favoritas y apoya el comercio de proximidad sin salir de casa.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-8 card-destacada">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <div class="card-header-front text-center pt-4">
                            <span class="badge bg-primary mb-2 px-3 py-2 rounded-pill">Función Principal</span>
                            <h4 class="fw-bolder mb-1 text-dark" style="color: #7b52d9;">Para Comerciantes</h4>
                            <p class="text-secondary small">El panel de control definitivo para tu negocio.</p>
                        </div>
                        <div class="zen-graphic zen-purple" style="background: #f4edff;">
                            <div class="zen-blob-1"></div><div class="zen-blob-2"></div>
                            <i class="bi bi-shop text-white position-relative z-3" style="font-size: 6rem; filter: drop-shadow(0px 4px 10px rgba(0,0,0,0.3));"></i>
                        </div>
                    </div>
                    <div class="flip-card-back" style="background: #f4edff;">
                        <i class="bi bi-bar-chart-line fs-1 mb-3" style="color: #7b52d9;"></i>
                        <h4 class="fw-bold text-dark">Gestión Total</h4>
                        <p class="text-secondary mb-4">Administra tu inventario, actualiza tu escaparate digital, recibe pedidos y analiza tus ventas desde un panel intuitivo.</p>
                        <a href="{{ route('registro') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" style="background-color: #7b52d9; border:none;">Empieza a vender</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 z-1">
            <div class="flip-card">
                <div class="flip-card-inner">
                    <div class="flip-card-front">
                        <div class="card-header-front">
                            <h5 class="fw-bold mb-1 fs-4 text-dark">Conexión Directa</h5>
                            <p class="text-secondary small">Comunícate sin intermediarios.</p>
                        </div>
                        <div class="zen-graphic zen-green bg-light">
                            <div class="zen-blob-1"></div><div class="zen-blob-2"></div>
                            <i class="bi bi-chat-dots text-white position-relative z-3" style="font-size: 5rem; filter: drop-shadow(0px 4px 10px rgba(0,0,0,0.2));"></i>
                        </div>
                    </div>
                    <div class="flip-card-back bg-light">
                        <i class="bi bi-people fs-1 text-success mb-3"></i>
                        <h5 class="fw-bold text-dark">Crea Comunidad</h5>
                        <p class="text-secondary">Los clientes pueden chatear directamente con los comerciantes para consultar stock, tallas o hacer encargos personalizados.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection