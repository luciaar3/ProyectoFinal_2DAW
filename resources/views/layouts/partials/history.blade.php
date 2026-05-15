<style>
    /* Sección Historia */
    .leading-relaxed { line-height: 1.8; }
    .shadow-inner { box-shadow: inset 0 2px 10px rgba(0,0,0,0.05); }
    
    /* Animación de entrada para las fotos al hacer scroll */
    #nuestra-historia img {
        transition: all 0.5s ease;
    }
    #nuestra-historia img:hover {
        transform: scale(1.03) translateY(-5px);
        box-shadow: 0 20px 40px rgba(245, 48, 3, 0.2) !important;
    }
    .btn-mercazone {
        background-color: #f53003 !important;
        color: #ffffff !important;
        border: 2px solid #f53003 !important;
        font-weight: 600;
        transition: all 0.3s ease-in-out;
    }

    .btn-mercazone:hover {
        background-color: #d42902 !important; /* Un tono un pelín más oscuro al pasar el cursor */
        border-color: #d42902 !important;
        color: #ffffff !important;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(245, 48, 3, 0.3) !important;
    }
</style>

<section id="nuestra-historia" class="py-5">
    <div class="container main-wrapper shadow-lg" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border-radius: 32px; border: 1px solid rgba(255, 255, 255, 0.6);">
        
        <div class="text-center mb-5">
            <span class="badge px-3 py-2 mb-3 rounded-pill" style="background-color: rgba(245, 48, 3, 0.1); color: #f53003; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">Más que comercio, es vida</span>
            <h2 class="display-4 fw-bolder text-dark" style="letter-spacing: -2px;">El alma de <span style="color: #f53003;">MercaZone</span></h2>
            <div class="mx-auto mt-2" style="width: 80px; height: 4px; background-color: #f53003; border-radius: 10px;"></div>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-lg-6 px-lg-5">
                <h4 class="fw-bold text-dark mb-3">Bajo el frío y el sol</h4>
                <p class="text-secondary leading-relaxed">
                    MercaZone nace de una profunda admiración por quienes no entienden de domingos ni de festivos. Hemos visto vuestras manos frías montando estructuras metálicas a las seis de la mañana, y vuestra frente sudada bajo el sol de agosto, siempre con una palabra amable preparada. 
                </p>
                <p class="text-secondary">
                    Ese esfuerzo titánico es el que sostiene nuestros barrios. No podíamos permitir que el silencio digital apagara el eco de vuestros pregones. Queríamos que vuestro sacrificio tuviera la visibilidad que merece.
                </p>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="position-relative p-2" style="border: 1px solid rgba(245, 48, 3, 0.3); border-radius: 24px; background: white;">
                    <img src="{{ asset('storage/img/3.jpg') }}" alt="El esfuerzo diario" class="img-fluid shadow-sm" style="border-radius: 20px; width: 100%; object-fit: cover; height: 350px;">
                    <div class="position-absolute top-0 end-0 bg-mercazone m-3 px-3 py-1 rounded-pill shadow-sm small fw-bold">Honor a la tradición</div>
                </div>
            </div>
        </div>

        <div class="row align-items-center mb-5 flex-column-reverse flex-lg-row">
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="position-relative">
                    <img src="{{ asset('storage/img/4.jpg') }}" alt="La familia del mercado" class="img-fluid shadow-lg" style="border-radius: 24px; transform: rotate(1deg); width: 100%; height: 400px; object-fit: cover; filter: contrast(1.1);">
                    <div class="position-absolute bottom-0 start-0 m-4 p-3 bg-white rounded-4 shadow-lg border-start border-5 border-danger" style="max-width: 250px;">
                        <p class="mb-0 small fw-bold text-dark">"Aquí no eres un código de barras, aquí tienes nombre."</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 px-lg-5">
                <h4 class="fw-bold text-dark mb-3">Donde los clientes son nombres, no números</h4>
                <p class="text-secondary leading-relaxed">
                    En los grandes almacenes eres un ticket; en el mercado eres "el de siempre". Esa calidez de acordarte de cómo le gusta el pan a tu vecino o de preguntar por la familia mientras pesas el género es un tesoro que ninguna inteligencia artificial podrá replicar.
                </p>
                <p class="text-secondary">
                    MercaZone es el guardián de esa <strong>personalización humana</strong>. Nuestra tecnología solo tiene un objetivo: que ese "tú a tú" siga ocurriendo cada día, facilitando que el encuentro se produzca sin importar las distancias digitales.
                </p>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-6 px-lg-5">
                <h4 class="fw-bold text-dark mb-3">La calidez que hace ciudad</h4>
                <p class="text-secondary">
                    Cuando un mercado está vivo, el barrio respira. Esa energía, ese brindis improvisado al terminar la jornada y esa red de apoyo mutuo es lo que realmente nos mueve. No estamos creando una simple plataforma de ventas; estamos blindando el estilo de vida que amamos.
                </p>
                <p class="text-secondary fw-bold" style="color: #f53003;">
                    Por los que estuvieron, por los que están y por los que vendrán: MercaZone es vuestra casa digital.
                </p>
                <div class="mt-4">
                    @guest
                    <a href="{{ route('registro') }}" class="btn btn-mercazone btn-lg rounded-pill px-5 py-3 shadow-lg">
                        <i class="bi bi-shop-window me-2"></i> Unirme a la Zona
                    </a>
                    @endguest
                    @auth
                        @if(auth()->user()->rol === 'Cliente')
                            <a href="{{ route('cliente.account') }}" class="btn btn-mercazone btn-lg rounded-pill px-5 py-3 shadow-lg">
                                <i class="bi bi-speedometer2 me-2"></i> Ir a mi Panel
                            </a>
                        @elseif(auth()->user()->rol === 'Comerciante')
                            <a href="{{ route('comerciante.account') }}" class="btn btn-mercazone btn-lg rounded-pill px-5 py-3 shadow-lg">
                                <i class="bi bi-shop me-2"></i> Gestionar mi Comercio
                            </a>
                        @elseif(auth()->user()->rol === 'Admin')
                            <a href="{{ route('admin.account') }}" class="btn btn-mercazone btn-lg rounded-pill px-5 py-3 shadow-lg">
                                <i class="bi bi-shield-lock me-2"></i> Panel de Control
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="p-2 bg-white shadow-sm border" style="border-radius: 28px;">
                    <img src="{{ asset('storage/img/5.jpg') }}" alt="El corazón del barrio" class="img-fluid" style="border-radius: 22px; width: 100%; height: 380px; object-fit: cover;">
                </div>
            </div>
        </div>

    </div>
</section>