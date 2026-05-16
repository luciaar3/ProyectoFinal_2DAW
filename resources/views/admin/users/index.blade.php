@extends('layouts.layout')

@section('title', __('admin_users.page_title'))

@section('content')
<div class="container mt-5 pt-4 mb-5">
    
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 py-1" style="background: transparent;">
                <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none fw-medium text-secondary hover-link">{{ __('admin_users.breadcrumb_home') }}</a></li>
                <li class="breadcrumb-item"><a href="#" onclick="window.history.back();" class="text-decoration-none fw-medium text-secondary hover-link">{{ __('admin_users.breadcrumb_panel') }}</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page" style="color: #f53003;">{{ __('admin_users.breadcrumb_active') }}</li>
            </ol>
        </nav>
        
        <button onclick="window.history.back();" class="btn btn-light rounded-pill px-3 py-2 btn-volver border d-flex align-items-center gap-2 bg-white text-secondary small fw-bold shadow-sm">
            <i class="bi bi-arrow-left fs-6 text-dark"></i> {{ __('admin_users.btn_back') }}
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 24px;">
        <div class="card-body p-4 p-md-5">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h3 class="fw-bolder text-dark mb-1" style="letter-spacing: -1px;">{{ __('admin_users.heading_title') }}</h3>
                    <p class="text-secondary small mb-0">{{ __('admin_users.heading_desc') }}</p>
                </div>
                <span class="badge rounded-pill px-3 py-2 align-self-start align-self-md-center" style="background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; font-weight: 600; font-size: 0.9rem;">
                    {{ __('admin_users.total_accounts', ['count' => $users->total()]) }}
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0 8px;">
                    <thead>
                        <tr class="text-secondary small fw-bold" style="border-bottom: 2px solid #f8f9fa;">
                            <th class="ps-3" style="width: 80px;">{{ __('admin_users.th_initial') }}</th>
                            <th>{{ __('admin_users.th_name') }}</th>
                            <th>{{ __('admin_users.th_email') }}</th>
                            <th>{{ __('admin_users.th_role') }}</th>
                            <th>{{ __('admin_users.th_date') }}</th>
                            <th class="text-end pe-3" style="width: 120px;">{{ __('admin_users.th_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                            <tr class="bg-white shadow-sm-hover" style="border-radius: 16px; transition: all 0.2s;">
                                <td class="ps-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold shadow-inner" 
                                         style="width: 40px; height: 40px; background-color: rgba(245, 48, 3, 0.06); color: #f53003; font-size: 0.95rem;">
                                        {{ substr($u->nombre, 0, 1) }}
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="fw-bold text-dark">{{ $u->nombre }}</div>
                                    <div class="text-muted small">{{ $u->primer_apellido }} {{ $u->segundo_apellido }}</div>
                                </td>
                                
                                <td class="text-secondary font-monospace small">
                                    {{ $u->email }}
                                </td>
                                
                                <td>
                                    @if($u->rol === 'Admin')
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545; font-weight: 600;">{{ __('admin_users.role_admin') }}</span>
                                    @elseif($u->rol === 'Comerciante')
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(245, 48, 3, 0.1); color: #f53003; font-weight: 600;">{{ __('admin_users.role_merchant') }}</span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; font-weight: 600;">{{ __('admin_users.role_client') }}</span>
                                    @endif
                                </td>
                                
                                <td class="text-muted small pe-3">
                                    {{ $u->created_at ? $u->created_at->format('d/m/Y') : __('admin_users.unknown_date') }}
                                </td>

                                <td class="text-end pe-3">
                                    @if($u->id !== Auth::user()->id)
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('{{ __('admin_users.confirm_delete') }}');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                <i class="bi bi-trash"></i> {{ __('admin_users.btn_delete') }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">{{ __('admin_users.current_user') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2 opacity-50"></i>
                                    {{ __('admin_users.empty_users') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>

<style>
    .shadow-inner {
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.03);
    }
    .hover-link:hover {
        color: #f53003 !important;
    }
    .btn-volver:hover {
        background-color: #f8f9fa !important;
        color: #f53003 !important;
        transform: translateX(-2px);
        transition: all 0.2s ease;
    }
    .shadow-sm-hover:hover {
        background-color: #fafafa !important;
    }
    table th {
        border-bottom: none !important;
    }
</style>
@endsection