<footer class="mt-5 pt-5 pb-4" style="background-color: #ffffff; border-top: 1px solid #eee;">
    <div class="container-fluid px-4 px-md-5"> 
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <a class="navbar-brand fw-bolder fs-4 d-flex align-items-center mb-3" href="{{ route('index') }}" style="letter-spacing: -1.5px;">
                    <div class="me-2 d-flex align-items-center justify-content-center" 
                         style="background-color: #f53003; width: 32px; height: 32px; border-radius: 8px; transform: rotate(-5deg);">
                        <i class="bi bi-shop-window text-white" style="font-size: 1.1rem; transform: rotate(5deg);"></i>
                    </div>
                    <span class="text-dark">Merca</span><span style="color: #f53003;">Zone</span>
                </a>
                <p class="text-secondary small" style="max-width: 300px;">
                    {{ __('messages.footer_desc') }}
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-secondary"><i class="bi bi-instagram fs-5 hover-red"></i></a>
                    <a href="#" class="text-secondary"><i class="bi bi-facebook fs-5 hover-red"></i></a>
                    <a href="#" class="text-secondary"><i class="bi bi-twitter-x fs-5 hover-red"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-dark mb-3">{{ __('messages.footer_nav') }}</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('index') }}" class="text-secondary text-decoration-none hover-red">{{ __('messages.footer_home') }}</a></li>
                    <li class="mb-2"><a href="{{ route('index') }}#nuestra-historia" class="text-secondary text-decoration-none hover-red">{{ __('messages.nav_history') }}</a></li>
                    <li class="mb-2"><a href="{{ route('negocios.index') }}" class="text-secondary text-decoration-none hover-red">{{ __('messages.footer_map') }}</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-dark mb-3">{{ __('messages.footer_legal') }}</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-red">{{ __('messages.footer_terms') }}</a></li>
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-red">{{ __('messages.footer_privacy') }}</a></li>
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-red">{{ __('messages.footer_cookies') }}</a></li>
                </ul>
            </div>

            @guest
                <div class="col-lg-4 col-md-6 d-flex justify-content-lg-end">
                    <div class="p-4 rounded-4 ms-lg-auto w-100" style="background-color: #fff8f7; border-radius: 24px; border: 1px solid #ffe5e0; max-width: 340px;">
                        <h6 class="fw-bold text-dark mb-2">{{ __('messages.footer_merchant_title') }}</h6>
                        <p class="text-secondary small mb-3">{{ __('messages.footer_merchant_desc') }}</p>
                        <a href="{{ route('registro') }}" class="btn btn-sm btn-mercazone w-100 rounded-pill fw-bold" style="background-color: #f53003; color: white; border: none; py: 2px;">
                            {{ __('messages.footer_merchant_btn') }}
                        </a>
                    </div>
                </div>
            @endguest

            @auth
                <div class="col-lg-4 col-md-6 d-flex justify-content-lg-end">
                    <div class="p-4 rounded-4 ms-lg-auto w-100" style="background-color: #f8f9fa; border-radius: 24px; border: 1px solid #eee; max-width: 340px;">
                        <h6 class="fw-bold text-dark mb-2"><i class="bi bi-life-preserver text-danger me-2"></i>{{ __('messages.footer_help_title') }}</h6>
                        <p class="text-secondary small mb-3">{{ __('messages.footer_help_desc') }}</p>
                        <a href="{{ route('foros.index') }}" class="btn btn-sm btn-outline-dark w-100 rounded-pill fw-bold py-2">
                            {{ __('messages.footer_help_btn') }}
                        </a>
                    </div>
                </div>
            @endauth
        </div>

        <hr class="mt-5 mb-4 opacity-50">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <small class="text-muted">&copy; {{ date('Y') }} MercaZone. {{ __('messages.footer_rights') }}</small>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <small class="text-muted">{!! __('messages.footer_crafted', ['heart' => '<i class="bi bi-heart-fill text-danger mx-1"></i>']) !!}</small>
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