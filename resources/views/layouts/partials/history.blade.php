<style>
    .leading-relaxed { line-height: 1.8; }
    .shadow-inner { box-shadow: inset 0 2px 10px rgba(0,0,0,0.05); }

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
        background-color: #d42902 !important;
        border-color: #d42902 !important;
        color: #ffffff !important;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(245, 48, 3, 0.3) !important;
    }
</style>

<section id="nuestra-historia" class="py-5">
    <div class="container main-wrapper shadow-lg" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border-radius: 32px; border: 1px solid rgba(255, 255, 255, 0.6);">
        
        <div class="text-center mb-5">
            <span class="badge px-3 py-2 mb-3 rounded-pill" style="background-color: rgba(245, 48, 3, 0.1); color: #f53003; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">{{ __('messages.hist_badge') }}</span>
            <h2 class="display-4 fw-bolder text-dark" style="letter-spacing: -2px;">{{ __('messages.hist_title') }} <span style="color: #f53003;">MercaZone</span></h2>
            <div class="mx-auto mt-2" style="width: 80px; height: 4px; background-color: #f53003; border-radius: 10px;"></div>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-lg-6 px-lg-5">
                <h4 class="fw-bold text-dark mb-3">{{ __('messages.hist_sec1_title') }}</h4>
                <p class="text-secondary leading-relaxed">
                    {{ __('messages.hist_sec1_p1') }}
                </p>
                <p class="text-secondary">
                    {{ __('messages.hist_sec1_p2') }}
                </p>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="position-relative p-2" style="border: 1px solid rgba(245, 48, 3, 0.3); border-radius: 24px; background: white;">
                    <img src="{{ asset('storage/img/3.jpg') }}" alt="MercaZone History" class="img-fluid shadow-sm" style="border-radius: 20px; width: 100%; object-fit: cover; height: 350px;">
                    <div class="position-absolute top-0 end-0 bg-mercazone text-white m-3 px-3 py-1 rounded-pill shadow-sm small fw-bold">{{ __('messages.hist_sec1_badge') }}</div>
                </div>
            </div>
        </div>

        <div class="row align-items-center mb-5 flex-column-reverse flex-lg-row">
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="position-relative">
                    <img src="{{ asset('storage/img/4.jpg') }}" alt="MercaZone Family" class="img-fluid shadow-lg" style="border-radius: 24px; transform: rotate(1deg); width: 100%; height: 400px; object-fit: cover; filter: contrast(1.1);">
                    <div class="position-absolute bottom-0 start-0 m-4 p-3 bg-white rounded-4 shadow-lg border-start border-5 border-danger" style="max-width: 250px;">
                        <p class="mb-0 small fw-bold text-dark">{{ __('messages.hist_sec2_quote') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 px-lg-5">
                <h4 class="fw-bold text-dark mb-3">{{ __('messages.hist_sec2_title') }}</h4>
                <p class="text-secondary leading-relaxed">
                    {{ __('messages.hist_sec2_p1') }}
                </p>
                <p class="text-secondary">
                    {{ __('messages.hist_sec2_p2') }}
                </p>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-lg-6 px-lg-5">
                <h4 class="fw-bold text-dark mb-3">{{ __('messages.hist_sec3_title') }}</h4>
                <p class="text-secondary">
                    {{ __('messages.hist_sec3_p1') }}
                </p>
                <p class="text-secondary fw-bold" style="color: #f53003;">
                    {{ __('messages.hist_sec3_p2') }}
                </p>
                <div class="mt-4">
                    @guest
                    <a href="{{ route('registro') }}" class="btn btn-mercazone btn-lg rounded-pill px-5 py-3 shadow-lg text-white">
                        <i class="bi bi-shop-window me-2"></i> {{ __('messages.hist_btn_join') }}
                    </a>
                    @endguest
                    @auth
                        @if(auth()->user()->rol === 'Cliente')
                            <a href="{{ route('cliente.account') }}" class="btn btn-mercazone btn-lg rounded-pill px-5 py-3 shadow-lg text-white">
                                <i class="bi bi-speedometer2 me-2"></i> {{ __('messages.hist_btn_panel') }}
                            </a>
                        @elseif(auth()->user()->rol === 'Comerciante')
                            <a href="{{ route('comerciante.account') }}" class="btn btn-mercazone btn-lg rounded-pill px-5 py-3 shadow-lg text-white">
                                <i class="bi bi-shop me-2"></i> {{ __('messages.hist_btn_manage') }}
                            </a>
                        @elseif(auth()->user()->rol === 'Admin')
                            <a href="{{ route('admin.account') }}" class="btn btn-mercazone btn-lg rounded-pill px-5 py-3 shadow-lg text-white">
                                <i class="bi bi-shield-lock me-2"></i> {{ __('messages.hist_btn_admin') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="p-2 bg-white shadow-sm border" style="border-radius: 28px;">
                    <img src="{{ asset('storage/img/5.jpg') }}" alt="MercaZone" class="img-fluid" style="border-radius: 22px; width: 100%; height: 380px; object-fit: cover;">
                </div>
            </div>
        </div>

    </div>
</section>