<div class="card h-100 border-0 shadow-sm" style="border-radius: 24px;">
    <div class="card-body p-5">
        <h4 class="fw-bold mb-4 text-dark">Editar Datos del Negocio</h4>
        <form action="{{ route('comerciante.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nombre del Negocio</label>
                <input type="text" name="Nombre" class="form-control" value="{{ $user->negocio->Nombre ?? '' }}">
            </div>

            <button type="submit" class="btn btn-primary w-100 rounded-pill">Actualizar Negocio</button>
        </form>
    </div>
</div>