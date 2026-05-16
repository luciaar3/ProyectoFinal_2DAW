@extends('layouts.layout')

@section('title', __('admin_validations.page_title'))

@section('content')
<div class="container mt-5 pt-4 mb-5">
    
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 px-0" style="background: transparent;">
                <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none fw-medium text-secondary hover-link">{{ __('admin_validations.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item"><a href="#" onclick="window.history.back();" class="text-decoration-none fw-medium text-secondary hover-link">{{ __('admin_validations.breadcrumb_panel') }}</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page" style="color: #f53003;">{{ __('admin_validations.breadcrumb_active') }}</li>
            </ol>
        </nav>
        
        <button onclick="window.history.back();" class="btn btn-light rounded-pill px-3 py-2 btn-volver border d-flex align-items-center gap-2 bg-white text-secondary small fw-bold shadow-sm">
            <i class="bi bi-arrow-left fs-6 text-dark"></i> {{ __('admin_validations.btn_back') }}
        </button>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
        <div>
            <h3 class="fw-bolder text-dark mb-1" style="letter-spacing: -1px;">{{ __('admin_validations.heading_title') }}</h3>
            <p class="text-secondary small mb-0">{{ __('admin_validations.heading_desc') }}</p>
        </div>
        <span class="badge rounded-pill bg-dark px-3 py-2 fw-bold shadow-sm">
            {{ __('admin_validations.requests_count', ['count' => count($pendientes)]) }}
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background: linear-gradient(135deg, #e6f8f3 0%, #d2f7ea 100%); border-left: 5px solid #198754 !important; color: #0f5132; border-radius: 16px; padding: 16px 24px;">
            <div class="d-flex align-items-center gap-2 fw-semibold">
                <i class="bi bi-check-circle-fill fs-5" style="color: #198754;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(count($pendientes) > 0)
        <div class="card border-0 shadow-sm custom-table-card" style="border-radius: 20px; overflow: hidden;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary uppercase-header">
                        <tr>
                            <th class="ps-4 py-3" style="font-size: 0.8rem; font-weight: 700;">{{ __('admin_validations.th_merchant') }}</th>
                            <th class="py-3" style="font-size: 0.8rem; font-weight: 700;">{{ __('admin_validations.th_nif') }}</th>
                            <th class="py-3" style="font-size: 0.8rem; font-weight: 700;">{{ __('admin_validations.th_permit') }}</th>
                            <th class="py-3" style="font-size: 0.8rem; font-weight: 700; min-width: 150px;">{{ __('admin_validations.th_status') }}</th>
                            <th class="pe-4 py-3 text-end" style="font-size: 0.8rem; font-weight: 700; width: 220px;">{{ __('admin_validations.th_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="border-0">
                        @foreach($pendientes as $negocio)
                            <tr class="main-row">
                                <td class="ps-4 py-3.5">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-box text-white rounded-3 d-flex align-items-center justify-content-center fw-bold me-3 shadow-inner" 
                                             style="width: 44px; height: 44px; background: #1b1b18;">
                                            {{ strtoupper(substr($negocio->nombre_negocio, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="d-block fw-bold text-dark mb-0 fs-6">{{ $negocio->nombre_negocio }}</span>
                                            <small class="text-secondary fs-7.5">{{ __('admin_validations.applicant') }} <span class="fw-medium text-dark">{{ $negocio->user->nombre ?? $negocio->user->name }}</span></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5">
                                    <code class="text-dark bg-light border px-2 py-1 rounded fw-bold small shadow-inner-sm">{{ $negocio->nif }}</code>
                                </td>
                                <td class="py-3.5 text-secondary font-monospace fw-medium">
                                    #{{ $negocio->numero_permiso }}
                                </td>
                                <td class="py-3.5">
                                    <span class="badge rounded-pill px-2.5 py-1.5 fw-bold bg-warning bg-opacity-10 text-warning border border-warning border-opacity-10 style-badge">
                                        <i class="bi bi-clock-history me-1"></i> {{ __('admin_validations.status_pending') }}
                                    </span>
                                </td>
                                <td class="pe-4 py-3.5 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-light border rounded-pill px-3 fw-bold text-secondary btn-inspect" 
                                                type="button" data-bs-toggle="collapse" data-bs-target="#details-{{ $negocio->id }}">
                                            <i class="bi bi-eye me-1 text-dark"></i> {{ __('admin_validations.btn_details') }}
                                        </button>
                                        
                                        <form action="{{ route('admin.aprobar', $negocio->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-circle shadow-sm btn-quick-action" title="{{ __('admin_validations.title_approve_now') }}">
                                                <i class="bi bi-check2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr id="details-{{ $negocio->id }}" class="collapse bg-light bg-opacity-50 border-0">
                                <td colspan="5" class="px-4 py-4 border-0" style="background-color: #fafafa; border-left: 4px solid #f53003 !important;">
                                    <div class="row g-3">
                                        <div class="col-md-8">
                                            <h6 class="fw-bold text-dark mb-2"><i class="bi bi-file-earmark-text me-1 text-secondary"></i> {{ __('admin_validations.details_heading') }}</h6>
                                            <p class="text-secondary small mb-0 lh-base bg-white p-3 border rounded-3 shadow-inner">
                                                {{ $negocio->descripcion ?? __('admin_validations.no_description') }}
                                            </p>
                                        </div>
                                        <div class="col-md-4 d-flex flex-column justify-content-end align-items-md-end gap-2">
                                            <h6 class="fw-bold text-dark mb-2 w-100 text-md-end small text-uppercase text-muted" style="letter-spacing: 0.5px;">{{ __('admin_validations.resolution_heading') }}</h6>
                                            <div class="d-flex gap-2 w-100 justify-content-md-end">
                                                <form action="{{ route('admin.rechazar', $negocio->id) }}" method="POST" onsubmit="return confirm('{{ __('admin_validations.confirm_deny') }}');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4 py-2 fw-bold">
                                                        <i class="bi bi-x-circle me-1"></i> {{ __('admin_validations.btn_deny') }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.aprobar', $negocio->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm rounded-pill px-4 py-2 fw-bold shadow-sm" style="background: linear-gradient(135deg, #198754 0%, #157347 100%); border: none;">
                                                        <i class="bi bi-check-circle me-1"></i> {{ __('admin_validations.btn_authorize') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 20px;">
            <div class="card-body">
                <div class="d-inline-flex align-items-center justify-content-center bg-light text-muted rounded-circle mb-3 shadow-inner" style="width: 80px; height: 80px;">
                    <i class="bi bi-check-all fs-1 text-success"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">{{ __('admin_validations.empty_title') }}</h4>
                <p class="text-secondary small mb-0">{{ __('admin_validations.empty_desc') }}</p>
            </div>
        </div>
    @endif
</div>

<style>
    /* Estilos de Tabla Avanzados */
    .custom-table-card {
        border: 1px solid rgba(0,0,0,0.06);
    }
    .uppercase-header th {
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #6c757d;
        background-color: #fdfdfd;
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }
    .main-row {
        transition: background-color 0.2s ease;
    }
    .main-row:hover {
        background-color: #fcfcfb !important;
    }

    /* Elementos visuales complementarios */
    .shadow-inner { box-shadow: inset 0 2px 4px rgba(0,0,0,0.05); }
    .shadow-inner-sm { box-shadow: inset 0 1px 2px rgba(0,0,0,0.02); }
    .fs-7.5 { font-size: 0.8rem; }
    .style-badge { font-size: 0.75rem; letter-spacing: 0.3px; }

    /* Botonera Interactiva */
    .btn-quick-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s;
    }
    .btn-quick-action:hover {
        transform: scale(1.1);
    }
    .btn-inspect {
        transition: all 0.2s ease;
    }
    .btn-inspect:hover {
        background-color: #e9ecef !important;
        color: #1b1b18 !important;
    }
    .btn-volver:hover {
        color: #f53003 !important;
        transform: translateX(-2px);
        transition: 0.2s;
    }
    .hover-link:hover { color: #f53003 !important; }
</style>
@endsection