<footer class="mt-5 pt-5 pb-4" style="background-color: #ffffff; border-top: 1px solid #eee;">
    <div class="container-fluid px-4 px-md-5"> 
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <a class="navbar-brand fw-bolder fs-4 d-flex align-items-center mb-3" href="/" style="letter-spacing: -1.5px;">
                    <div class="me-2 d-flex align-items-center justify-content-center" 
                         style="background-color: #f53003; width: 32px; height: 32px; border-radius: 8px; transform: rotate(-5deg);">
                        <i class="bi bi-shop-window text-white" style="font-size: 1.1rem; transform: rotate(5deg);"></i>
                    </div>
                    <span class="text-dark">Merca</span><span style="color: #f53003;">Zone</span>
                </a>
                <p class="text-secondary small" style="max-width: 300px;">
                    Digitalizando el comercio local y ambulante para conectar la tradición de nuestros barrios con el futuro digital.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-secondary"><i class="bi bi-instagram fs-5 hover-red"></i></a>
                    <a href="#" class="text-secondary"><i class="bi bi-facebook fs-5 hover-red"></i></a>
                    <a href="#" class="text-secondary"><i class="bi bi-twitter-x fs-5 hover-red"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-dark mb-3">Navegación</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="/" class="text-secondary text-decoration-none hover-red">Inicio</a></li>
                    <li class="mb-2"><a href="#nuestra-historia" class="text-secondary text-decoration-none hover-red">Nuestra Historia</a></li>
                    <li class="mb-2"><a href="{{ route('negocios.index') }}" class="text-secondary text-decoration-none hover-red">Explorar Mapa</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-dark mb-3">Legal</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-red">Términos y Condiciones</a></li>
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-red">Política de Privacidad</a></li>
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-red">Cookies</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="p-4 rounded-4" style="background-color: #fff8f7; border-radius: 24px; border: 1px solid #ffe5e0;">
                    <h6 class="fw-bold text-dark mb-2">¿Eres comerciante?</h6>
                    <p class="text-secondary small mb-3">Únete a la red de MercaZone y empieza a digitalizar tus productos hoy mismo.</p>
                    <a href="{{ route('registro') }}" class="btn btn-sm btn-mercazone w-100 rounded-pill fw-bold" style="background-color: #f53003; color: white; border: none;">Registrar mi puesto</a>
                </div>
            </div>
        </div>

        <hr class="mt-5 mb-4 opacity-50">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <small class="text-muted">&copy; {{ date('Y') }} MercaZone. Todos los derechos reservados.</small>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <small class="text-muted">Hecho con <i class="bi bi-heart-fill text-danger"></i> para el comercio local.</small>
            </div>
        </div>
    </div>
</footer>

<style>
    .hover-red:hover {
        color: #f53003 !important;
        transition: 0.3s;
    }
    
    .btn-mercazone {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-mercazone:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 48, 3, 0.2) !important;
        color: white !important;
    }
</style>