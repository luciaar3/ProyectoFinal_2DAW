<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm sticky-top" style="border-bottom: 2px solid #f53003;">
    <div class="container-fluid px-4 px-md-5">
        <a class="navbar-brand fw-bolder fs-4 d-flex align-items-center" href="/" style="letter-spacing: -1.5px;">
            <div class="me-2 d-flex align-items-center justify-content-center" 
                 style="background-color: #f53003; width: 40px; height: 40px; border-radius: 12px; transform: rotate(-5deg);">
                <i class="bi bi-shop-window text-white" style="font-size: 1.4rem; transform: rotate(5deg);"></i>
            </div>
            <span class="text-dark">Merca</span><span style="color: #f53003;">Zone</span>
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center fw-medium">
                
                <li class="nav-item me-lg-4">
                    <a class="nav-link text-secondary nav-link-hover" href="{{ route('index') }}#nuestra-historia">
                        <i class="bi bi-info-circle me-1"></i> {{ __('messages.nav_history') }}
                    </a>
                </li>

                <li class="nav-item dropdown me-lg-3 my-2 my-lg-0">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-1 btn btn-sm btn-light rounded-pill px-3 shadow-sm border text-secondary" 
                       href="#" id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-translate text-danger"></i> 
                        <span class="text-uppercase fw-bold small">{{ app()->getLocale() }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 animate-slide" style="border-radius: 12px; min-width: 130px;">
                        <li><a class="dropdown-item py-2 fw-semibold @if(app()->getLocale() == 'es') active bg-danger text-white @endif" href="{{ route('lang.switch', 'es') }}">Castellano</a></li>
                        <li><a class="dropdown-item py-2 fw-semibold @if(app()->getLocale() == 'ca') active bg-danger text-white @endif" href="{{ route('lang.switch', 'ca') }}">Valencià</a></li>
                        <li><a class="dropdown-item py-2 fw-semibold @if(app()->getLocale() == 'en') active bg-danger text-white @endif" href="{{ route('lang.switch', 'en') }}">English</a></li>
                    </ul>
                </li>

                @guest
                    <li class="nav-item me-lg-3 mt-2 mt-lg-0">
                        <a class="nav-link fw-semibold text-dark nav-link-hover" href="{{ route('login') }}">{{ __('messages.nav_login') }}</a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="btn rounded-pill px-4 py-2 text-white fw-bold shadow-sm btn-main-action" 
                           style="background: linear-gradient(135deg, #f53003 0%, #ff6b4a 100%); border: none;" 
                           href="{{ route('registro') }}">
                             {{ __('messages.nav_register') }}
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-dark p-1 pe-3 rounded-pill user-dropdown-pill" 
                           href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            
                            <div class="text-white rounded-circle d-flex justify-content-center align-items-center fw-bold shadow-sm" 
                                 style="width: 35px; height: 35px; background: #1b1b18;">
                                {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}
                            </div>
                            <span>{{ explode(' ', Auth::user()->nombre)[0] }}</span>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate-slide" style="border-radius: 18px;">
                            <li><a class="dropdown-item py-2 fw-semibold" href="{{ route(Auth::user()->rol === 'Cliente' ? 'cliente.account' : (Auth::user()->rol === 'Admin' ? 'admin.account' : 'comerciante.account')) }}">
                                <i class="bi bi-grid-1x2 me-2"></i> {{ __('messages.nav_panel') }}</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger fw-bold">
                                        <i class="bi bi-door-open me-2"></i> {{ __('messages.nav_logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<style>
    .nav-link-hover:hover {
        color: #f53003 !important;
        transform: translateY(-1px);
        transition: 0.2s;
    }

    .btn-main-action:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(245, 48, 3, 0.3) !important;
        transition: 0.3s;
    }

    .user-dropdown-pill {
        border: 1px solid #eee;
        transition: 0.3s;
    }

    .user-dropdown-pill:hover {
        background-color: #f8f9fa;
        border-color: #f53003;
    }

    .animate-slide {
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>