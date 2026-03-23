<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bolder fs-4 d-flex align-items-center" href="/">
            <span style="color: #7b52d9;" class="me-2">◈</span> 
            Market Manager
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center fw-medium">
                @guest
                    <li class="nav-item me-lg-3 mt-3 mt-lg-0">
                        <a class="nav-link text-primary fw-semibold" href="{{ route('login') }}">Inicia sesión </a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="btn rounded-pill px-4 py-2 text-white fw-bold shadow-sm" style="background-color: #7b52d9; transition: opacity 0.3s;" href="{{ route('registro') }}" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                            Regístrate gratis <i class="bi bi-chevron-down" style="font-size: 0.8em;"></i>
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="text-white rounded-circle d-flex justify-content-center align-items-center fw-bold" style="width: 35px; height: 35px; font-size: 1rem; background-color: #7b52d9;">
                                {{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}
                            </div>
                            <span>Hola, <strong>{{ explode(' ', Auth::user()->nombre)[0] }}</strong></span>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item py-2 fw-semibold" href="{{ Auth::user()->rol === 'Cliente' ? route('account') : (Auth::user()->rol === 'Comerciante' ? route('comerciante.account') : route('admin.account')) }}">
                                    Mi Panel
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger fw-bold">
                                        Cerrar Sesión
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