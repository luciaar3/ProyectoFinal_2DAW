@extends('layouts.layout')

@section('title', 'Gestión de Catálogo - Market Manager')

@section('content')
<div class="container mt-5 pt-4 mb-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('comerciante.account') }}" class="text-decoration-none">Panel</a></li>
                    <li class="breadcrumb-item active">Catálogo</li>
                </ol>
            </nav>
            <h2 class="fw-bolder text-dark">Mi Catálogo de Productos</h2>
            <p class="text-secondary">Añade, edita o elimina los productos que ofreces en tu puesto.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <button class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAddProducto" style="background-color: #7b52d9; border: none;">
                <i class="bi bi-plus-lg me-2"></i> Nuevo Producto
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        @forelse($productos as $producto)
            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                    <div style="height: 200px; overflow: hidden; position: relative; background-color: #f8f9fa;">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                <i class="bi bi-image fs-1 opacity-25"></i>
                            </div>
                        @endif
                        <span class="position-absolute top-0 end-0 m-3 badge rounded-pill bg-white text-dark shadow-sm">
                            {{ $producto->precio }}€
                        </span>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold text-dark mb-0 text-truncate" style="max-width: 80%;">{{ $producto->nombre }}</h5>
                            <span class="badge bg-light text-secondary border rounded-pill">{{ $producto->categoria ?? 'General' }}</span>
                        </div>
                        <p class="text-secondary small mb-3 text-truncate-2" style="height: 40px;">{{ $producto->descripcion }}</p>
                        
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-box-seam me-2"></i> Stock: 
                            <span class="ms-1 fw-bold {{ $producto->stock < 5 ? 'text-danger' : 'text-dark' }}">
                                {{ $producto->stock }} uds.
                            </span>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 p-4 pt-0 d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm rounded-pill flex-grow-1 border-light-subtle edit-button" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalEditProducto"
                            data-id="{{ $producto->id }}"
                            data-nombre="{{ $producto->nombre }}"
                            data-precio="{{ $producto->precio }}"
                            data-stock="{{ $producto->stock }}"
                            data-categoria="{{ $producto->categoria }}"
                            data-descripcion="{{ $producto->descripcion }}">
                            <i class="bi bi-pencil me-1"></i> Editar
                        </button>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle" onclick="return confirm('¿Seguro que quieres eliminar este producto?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3 text-muted opacity-25">
                    <i class="bi bi-basket" style="font-size: 5rem;"></i>
                </div>
                <h4 class="text-secondary">No tienes productos todavía</h4>
                <p class="text-muted">Empieza por añadir tu primer producto usando el botón superior.</p>
            </div>
        @endforelse
    </div>
</div>

<div class="modal fade" id="modalAddProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Añadir Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre del producto</label>
                        <input type="text" name="nombre" class="form-control rounded-pill border-light-subtle" placeholder="Ej: Manzanas Fuji" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Precio (€)</label>
                            <input type="number" step="0.01" name="precio" class="form-control rounded-pill border-light-subtle" placeholder="0.00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Stock</label>
                            <input type="number" name="stock" class="form-control rounded-pill border-light-subtle" placeholder="10" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Categoría</label>
                        <input type="text" name="categoria" class="form-control rounded-pill border-light-subtle" placeholder="Ej: Frutas, Artesanía...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Descripción</label>
                        <textarea name="descripcion" class="form-control" style="border-radius: 15px;" rows="3" placeholder="Cuéntanos algo sobre el producto..."></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Foto</label>
                        <input type="file" name="imagen" class="form-control rounded-pill border-light-subtle">
                        <div class="form-text small">Tamaño máximo 2MB.</div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-toggle="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold" style="background-color: #7b52d9; border: none;">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditProducto" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre</label>
                        <input type="text" name="nombre" id="edit_nombre" class="form-control rounded-pill" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Precio (€)</label>
                            <input type="number" step="0.01" name="precio" id="edit_precio" class="form-control rounded-pill" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Stock</label>
                            <input type="number" name="stock" id="edit_stock" class="form-control rounded-pill" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Categoría</label>
                        <input type="text" name="categoria" id="edit_categoria" class="form-control rounded-pill">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Descripción</label>
                        <textarea name="descripcion" id="edit_descripcion" class="form-control" style="border-radius: 15px;" rows="2"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Nueva Foto (opcional)</label>
                        <input type="file" name="imagen" class="form-control rounded-pill">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold" style="background-color: #7b52d9; border: none;">Actualizar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }
</style>
<script>
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            // Cambiamos la URL del formulario dinámicamente
            document.getElementById('formEditProducto').action = `/comerciante/catalogo/${id}`;
            
            // Rellenamos los campos
            document.getElementById('edit_nombre').value = this.getAttribute('data-nombre');
            document.getElementById('edit_precio').value = this.getAttribute('data-precio');
            document.getElementById('edit_stock').value = this.getAttribute('data-stock');
            document.getElementById('edit_categoria').value = this.getAttribute('data-categoria');
            document.getElementById('edit_descripcion').value = this.getAttribute('data-descripcion');
        });
    });
</script>
@endsection