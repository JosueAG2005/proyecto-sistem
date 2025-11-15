@csrf
<div class="form-group"><label>Nombre *</label>
  <input name="nombre" class="form-control" value="{{ old('nombre', $maquinaria->nombre ?? '') }}" required>
</div>
<div class="form-group">
    <label>Categoría *</label>
    <select name="categoria_id" class="form-control" required>
        <option value="">Seleccione una categoría</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}"
                {{ old('categoria_id', $maquinaria->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group"><label>Tipo *</label>
  <input name="tipo" class="form-control" value="{{ old('tipo', $maquinaria->tipo ?? '') }}" required>
</div>
<div class="form-group"><label>Marca *</label>
  <input name="marca" class="form-control" value="{{ old('marca', $maquinaria->marca ?? '') }}" required>
</div>
<div class="form-group"><label>Modelo</label>
  <input name="modelo" class="form-control" value="{{ old('modelo', $maquinaria->modelo ?? '') }}">
</div>
<div class="form-group"><label>Precio por día *</label>
  <input type="number" step="0.01" name="precio_dia" class="form-control" value="{{ old('precio_dia', $maquinaria->precio_dia ?? 0) }}" required>
</div>
<div class="form-group"><label>Estado *</label>
  <select name="estado" class="form-control" required>
    @foreach(['disponible','en_mantenimiento','dado_baja'] as $e)
      <option value="{{ $e }}" @selected(old('estado', $maquinaria->estado ?? '')==$e)>{{ $e }}</option>
    @endforeach
  </select>
</div>
<div class="form-group"><label>Descripción</label>
  <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $maquinaria->descripcion ?? '') }}</textarea>
</div>
<button class="btn btn-success">Guardar</button>
<a href="{{ route('maquinarias.index') }}" class="btn btn-secondary">Volver</a>
