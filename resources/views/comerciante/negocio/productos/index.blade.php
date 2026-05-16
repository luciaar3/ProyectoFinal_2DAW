@extends('layouts.layout')

@section('title', __('products.page_title'))

@section('content')
<div class="container mt-5 pt-4 mb-5">
    
    {{-- ENCABEZADO --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1" style="background: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('comerciante.account') }}" class="text-decoration-none text-secondary hover-link fw-medium">{{ __('products.breadcrumb_panel') }}</a></li>
                    <li class="breadcrumb-item active fw-bold text-dark">{{ __('products.breadcrumb_catalog') }}</li>
                </ol>
            </nav>
            <h3 class="fw-bolder text-dark mb-1" style="letter-spacing: -1px;">{{ __('products.main_heading') }}</h3>
            <p class="text-secondary small mb-0">{{ __('products.sub_heading') }}</p>
        </div>
        <div>
            <button class="btn text-white rounded-pill px-4 py-2.5 fw-bold shadow-sm d-flex align-items-center gap-2" 
                    data-bs-toggle="modal" data-bs-target="#modalAddProducto" 
                    style="background: linear-gradient(135deg, #7b52d9 0%, #6336c7 100%); border: none;">
                <i class="bi bi-plus-lg fs-6"></i> {{ __('products.btn_new_product') }}
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #e6f8f3 0%, #d2f7ea 100%); border-left: 5px solid #198754 !important; color: #0f5132; border-radius: 16px;">
            <div class="d-flex align-items-center gap-2 fw-semibold p-1">
                <i class="bi bi-check-circle-fill fs-5" style="color: #198754;"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- LISTADO DE PRODUCTOS --}}
    <div class="row g-4">
        @forelse($productos as $producto)
            @php
                $nombresEtiquetas = $producto->etiquetas->pluck('nombre')->map(fn($n) => strtolower($n))->toArray();
                $esModa = in_array('ropa', $nombresEtiquetas) || in_array('calzado', $nombresEtiquetas);
            @endphp
            
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm card-producto position-relative" style="border-radius: 20px; overflow: hidden; background: #fff;">
                    
                    {{-- Contenedor de Imagen + Precio --}}
                    <div style="height: 220px; overflow: hidden; position: relative; background-color: #fdfdfd;">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="w-100 h-100 img-zoom" style="object-fit: cover;">
                        @else
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted bg-light bg-opacity-50">
                                <i class="bi bi-image fs-2 opacity-50 mb-1"></i>
                                <small class="text-uppercase tracking-wider text-muted font-monospace" style="font-size: 0.65rem;">{{ __('products.no_image') }}</small>
                            </div>
                        @endif
                        <span class="position-absolute bottom-0 start-0 m-3 badge bg-dark text-white fw-bold shadow-sm px-3 py-2" style="font-size: 0.85rem; border-radius: 10px;">
                            {{ number_format($producto->precio, 2) }}€
                        </span>
                    </div>

                    {{-- Cuerpo de la Tarjeta --}}
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                <h6 class="fw-bold text-dark mb-0 text-truncate" title="{{ $producto->nombre }}">{{ $producto->nombre }}</h6>
                                
                                {{-- Renderizado controlado de Etiquetas --}}
                                <div class="d-flex gap-1 flex-wrap justify-content-end">
                                    @foreach($producto->etiquetas as $etiqueta)
                                        <span class="badge rounded-pill px-2 py-1 fw-semibold text-capitalize style-badge-tag">
                                            {{ __('products.tags.' . strtolower($etiqueta->nombre)) ?? str_replace('_', ' ', $etiqueta->nombre) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <p class="text-secondary small mb-3 text-truncate-2 lh-sm" style="min-height: 36px;">{{ $producto->descripcion }}</p>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between text-muted border-top pt-2 mt-2">
                            <span class="small font-monospace"><i class="bi bi-box-seam me-1"></i> {{ __('products.stock_label') }}</span>
                            <span class="badge rounded-pill px-2.5 py-1.5 fw-bold {{ $producto->stock < 5 ? 'bg-danger bg-opacity-10 text-danger' : 'bg-light text-dark border' }}">
                                {{ $producto->stock }} {{ __('products.units_abbreviation') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 p-3 pt-0 d-flex gap-2">
                        <button class="btn btn-light border btn-sm rounded-pill flex-grow-1 edit-button fw-bold text-secondary text-center py-2"
                            data-bs-toggle="modal" data-bs-target="#modalEditProducto"
                            data-id="{{ $producto->id }}" data-nombre="{{ $producto->nombre }}"
                            data-precio="{{ $producto->precio }}" data-stock="{{ $producto->stock }}"
                            data-categoria="{{ $producto->etiquetas->first()->nombre ?? '' }}" data-descripcion="{{ $producto->descripcion }}">
                            <i class="bi bi-pencil me-1 text-dark"></i> {{ __('products.btn_edit') }}
                        </button>

                        @if($esModa)
                            <button class="btn btn-outline-primary btn-sm rounded-pill flex-grow-1 btn-variantes fw-bold text-center py-2" 
                                data-bs-toggle="modal" data-bs-target="#modalVariantes"
                                data-id="{{ $producto->id }}" data-nombre="{{ $producto->nombre }}">
                                <i class="bi bi-layers-half me-1"></i> {{ __('products.btn_sizes') }}
                            </button>
                        @endif

                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline m-0">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle d-flex align-items-center justify-content-center" 
                                    style="width: 36px; height: 36px; padding: 0;"
                                    onclick="return confirm('{{ __('products.confirm_delete') }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="d-inline-flex align-items-center justify-content-center bg-light text-muted rounded-circle mb-3 shadow-inner" style="width: 80px; height: 80px;">
                    <i class="bi bi-basket fs-2"></i>
                </div>
                <h5 class="fw-bold text-dark">{{ __('products.empty_title') }}</h5>
                <p class="text-secondary small">{{ __('products.empty_subtitle') }}</p>
            </div>
        @endforelse
    </div>
</div>

{{-- MODAL AÑADIR --}}
<div class="modal fade" id="modalAddProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0 text-dark">{{ __('products.modal_add_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 pt-2">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">{{ __('products.label_product_name') }}</label>
                        <input type="text" name="nombre" class="form-control rounded-pill border-light-subtle" placeholder="{{ __('products.placeholder_name') }}" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">{{ __('products.label_unit_price') }}</label>
                            <input type="number" step="0.01" name="precio" class="form-control rounded-pill border-light-subtle" placeholder="0.00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">{{ __('products.label_total_units') }}</label>
                            <input type="number" name="stock" class="form-control rounded-pill border-light-subtle" placeholder="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">{{ __('products.label_category_key') }}</label>
                        <select name="etiqueta_nombre" id="select-etiqueta-add" class="form-select rounded-pill border-light-subtle" required>
                            <option value="">{{ __('products.select_option_default') }}</option>
                            <option value="ropa">{{ __('products.tags.ropa') }}</option>
                            <option value="calzado">{{ __('products.tags.calzado') }}</option>
                            <option value="complementos">{{ __('products.tags.complementos') }}</option>
                            <option value="comida">{{ __('products.tags.comida') }}</option>
                            <option value="fruta_verdura">{{ __('products.tags.fruta_verdura') }}</option>
                            <option value="aroma">{{ __('products.tags.aroma') }}</option>
                            <option value="artesania">{{ __('products.tags.artesania') }}</option>
                            <option value="hogar">{{ __('products.tags.hogar') }}</option>
                            <option value="bisuteria">{{ __('products.tags.bisuteria') }}</option>
                            <option value="juguetes">{{ __('products.tags.juguetes') }}</option>
                        </select>
                    </div>

                    <div id="aviso-ropa-add" class="alert alert-primary border-0 rounded-4 d-none mb-3" style="background-color: #f5f3ff; color: #6336c7;">
                        <small class="fw-bold"><i class="bi bi-info-circle-fill me-1"></i> {{ __('products.alert_category_attributes') }}</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">{{ __('products.label_description_sheet') }}</label>
                        <textarea name="descripcion" class="form-control" style="border-radius: 16px;" rows="3" placeholder="{{ __('products.placeholder_description') }}"></textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">{{ __('products.label_image_file') }}</label>
                        <input type="file" name="imagen" class="form-control rounded-pill border-light-subtle">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn text-white w-100 rounded-pill fw-bold py-2.5" style="background-color: #7b52d9; border: none;">{{ __('products.btn_save_product') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDITAR --}}
<div class="modal fade" id="modalEditProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0 text-dark">{{ __('products.modal_edit_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditProducto" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body p-4 pt-2">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">{{ __('products.label_name') }}</label>
                        <input type="text" name="nombre" id="edit_nombre" class="form-control rounded-pill" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">{{ __('products.label_price') }}</label>
                            <input type="number" step="0.01" name="precio" id="edit_precio" class="form-control rounded-pill" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">{{ __('products.stock_label') }}</label>
                            <input type="number" name="stock" id="edit_stock" class="form-control rounded-pill" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">{{ __('products.label_main_category') }}</label>
                        <select name="etiqueta_nombre" id="edit_categoria" class="form-select rounded-pill border-light-subtle" required>
                            <option value="ropa">{{ __('products.tags.ropa') }}</option>
                            <option value="calzado">{{ __('products.tags.calzado') }}</option>
                            <option value="complementos">{{ __('products.tags.complementos') }}</option>
                            <option value="comida">{{ __('products.tags.comida') }}</option>
                            <option value="fruta_verdura">{{ __('products.tags.fruta_verdura') }}</option>
                            <option value="aroma">{{ __('products.tags.aroma') }}</option>
                            <option value="artesania">{{ __('products.tags.artesania') }}</option>
                            <option value="hogar">{{ __('products.tags.hogar') }}</option>
                            <option value="bisuteria">{{ __('products.tags.bisuteria') }}</option>
                            <option value="juguetes">{{ __('products.tags.juguetes') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">{{ __('products.label_description') }}</label>
                        <textarea name="descripcion" id="edit_descripcion" class="form-control" style="border-radius: 16px;" rows="3"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold">{{ __('products.label_replace_image') }}</label>
                        <input type="file" name="imagen" class="form-control rounded-pill">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="submit" class="btn text-white w-100 rounded-pill fw-bold py-2.5" style="background-color: #7b52d9; border: none;">{{ __('products.btn_update_changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL VARIANTES --}}
<div class="modal fade" id="modalVariantes" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow" style="border-radius: 24px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-sliders2-vertical text-muted me-2"></i>{{ __('products.modal_variants_of') }} <span id="span-nombre-producto" class="fw-normal text-secondary fs-6"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <div class="row g-2 mb-3 p-3 bg-light rounded-4 border">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">{{ __('products.label_attribute') }}</label>
                        <select id="tipo-atributo" class="form-select rounded-pill border-light-subtle">
                            <option value="Talla">{{ __('products.attributes.talla') }}</option>
                            <option value="Color">{{ __('products.attributes.color') }}</option>
                            <option value="Estampado">{{ __('products.attributes.estampado') }}</option>
                            <option value="Material">{{ __('products.attributes.material') }}</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold">{{ __('products.label_value') }}</label>
                        <input type="text" id="valor-atributo" class="form-control rounded-pill border-light-subtle" placeholder="{{ __('products.placeholder_value') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">{{ __('products.label_qty') }}</label>
                        <input type="number" id="stock-atributo" class="form-control rounded-pill border-light-subtle" value="1" min="1">
                    </div>
                </div>
                <button type="button" id="btn-confirmar-variante" class="btn text-white w-100 rounded-pill fw-bold" style="background-color: #1b1b18; border: none;">
                    <i class="bi bi-plus-circle me-1"></i> {{ __('products.btn_insert_variant') }}
                </button>
                
                <hr class="my-3 opacity-25">
                
                <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="small fw-bold border-0 text-secondary" style="font-size: 0.75rem;">{{ __('products.col_loaded_variant') }}</th>
                                <th class="small fw-bold border-0 text-secondary" style="font-size: 0.75rem;">{{ __('products.col_assigned_stock') }}</th>
                                <th class="small fw-bold border-0 text-secondary text-end" style="font-size: 0.75rem;">{{ __('products.col_remove') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-variantes-body">
                            {{-- Inyección JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
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
    .card-producto {
        border: 1px solid rgba(0,0,0,0.05) !important;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
    }
    .card-producto:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(123, 82, 217, 0.08) !important;
    }
    .img-zoom {
        transition: transform 0.4s ease;
    }
    .card-producto:hover .img-zoom {
        transform: scale(1.04);
    }
    .style-badge-tag {
        font-size: 0.65rem;
        background-color: #f3f0ff;
        color: #7b52d9;
    }
    .shadow-inner { box-shadow: inset 0 2px 4px rgba(0,0,0,0.04); }
    .hover-link:hover { color: #7b52d9 !important; }
</style>

<script>
    // --- MENSAJE DE ADVERTENCIA ---
    document.getElementById('select-etiqueta-add').addEventListener('change', function() {
        const val = this.value;
        const aviso = document.getElementById('aviso-ropa-add');
        if(val === 'ropa' || val === 'calzado') {
            aviso.classList.remove('d-none');
        } else {
            aviso.classList.add('d-none');
        }
    });

    let currentProductoId = null;

    // --- ATRIBUTOS PARA EDICIÓN ---
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            document.getElementById('formEditProducto').action = `/comerciante/catalogo/${id}`;
            document.getElementById('edit_nombre').value = this.getAttribute('data-nombre');
            document.getElementById('edit_precio').value = this.getAttribute('data-precio');
            document.getElementById('edit_stock').value = this.getAttribute('data-stock');
            document.getElementById('edit_descripcion').value = this.getAttribute('data-descripcion');
            
            const categoria = this.getAttribute('data-categoria');
            const selectCat = document.getElementById('edit_categoria');
            if (selectCat && categoria) {
                selectCat.value = categoria.toLowerCase();
            }
        });
    });

    // --- CARGA DE VARIANTES ---
    document.querySelectorAll('.btn-variantes').forEach(btn => {
        btn.addEventListener('click', function() {
            currentProductoId = this.dataset.id;
            document.getElementById('span-nombre-producto').innerText = this.dataset.nombre;
            cargarVariantes(currentProductoId);
        });
    });

    async function cargarVariantes(productoId) {
        const tbody = document.getElementById('tabla-variantes-body');
        if(!tbody) return;
        
        tbody.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-3 small">{{ __("products.js_searching_variants") }}</td></tr>';

        try {
            const response = await fetch(`/comerciante/productos/${productoId}/variantes`);
            const variantes = await response.json();
            tbody.innerHTML = '';
            
            if(variantes.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-3 small">{{ __("products.js_no_variants") }}</td></tr>';
                return;
            }

            variantes.forEach(v => {
                tbody.innerHTML += `
                    <tr>
                        <td class="fw-bold text-dark text-start small">${v.nombre_valor}</td>
                        <td><span class="badge bg-light text-dark border px-2.5 py-1 font-monospace">${v.stock}</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-danger rounded-circle p-0 d-inline-flex align-items-center justify-content-center" 
                                    style="width:26px; height:26px;" onclick="eliminarVariante(${v.id})">
                                <i class="bi bi-x"></i>
                            </button>
                        </td>
                    </tr>`;
            });
        } catch (error) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center text-danger py-3 small">{{ __("products.js_error_async") }}</td></tr>';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const btnGuardar = document.getElementById('btn-confirmar-variante');
        
        if (btnGuardar) {
            btnGuardar.addEventListener('click', async function() {
                const inputTipo = document.getElementById('tipo-atributo');
                const inputValor = document.getElementById('valor-atributo');
                const inputStock = document.getElementById('stock-atributo');

                if (!inputValor.value.trim() || !inputStock.value) {
                    alert("{{ __('products.js_alert_insert_value') }}");
                    return;
                }

                try {
                    const response = await fetch('/comerciante/productos/variantes', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            producto_id: currentProductoId,
                            tipo: inputTipo.value,
                            valor: inputValor.value.trim(),
                            stock: inputStock.value
                        })
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        inputValor.value = '';
                        inputStock.value = '1';
                        cargarVariantes(currentProductoId);
                    } else {
                        alert("{{ __('products.js_alert_error') }}: " + (data.message || "{{ __('products.js_error_transaction') }}"));
                    }
                } catch (error) {
                    alert("{{ __('products.js_alert_critical_error') }}");
                }
            });
        }
    });

    async function eliminarVariante(id) {
        if(!confirm("{{ __('products.js_confirm_delete_variant') }}")) return;
        
        try {
            const response = await fetch(`/comerciante/productos/variantes/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                cargarVariantes(currentProductoId); 
            } else {
                alert("{{ __('products.js_alert_no_delete') }}: " + (data.message || "{{ __('products.js_unknown_error') }}"));
            }
        } catch (error) {
            console.error("Error al eliminar:", error);
            alert("{{ __('products.js_alert_server_error') }}");
        }
    }
</script>
@endsection