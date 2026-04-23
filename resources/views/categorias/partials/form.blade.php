@php
    $categoria = $categoria ?? null;
@endphp

<div class="form-grid">
    <div class="field">
        <label for="nombre_categoria">Nombre</label>
        <input
            class="input"
            type="text"
            id="nombre_categoria"
            name="nombre_categoria"
            maxlength="100"
            value="{{ old('nombre_categoria', optional($categoria)->nombre_categoria) }}"
            required
        >
    </div>

    <div class="field">
        <label for="descripcion">Descripcion</label>
        <textarea class="textarea" id="descripcion" name="descripcion">{{ old('descripcion', optional($categoria)->descripcion) }}</textarea>
    </div>

    <div class="field">
        <label for="estado">Estado</label>
        <select class="select" id="estado" name="estado" required>
            <option value="1" @selected((string) old('estado', optional($categoria)->estado ?? '1') === '1')>Activa</option>
            <option value="0" @selected((string) old('estado', optional($categoria)->estado) === '0')>Inactiva</option>
        </select>
    </div>
</div>

<div class="form-actions">
    <a class="btn btn-light" href="{{ route('categorias.index') }}">Cancelar</a>
    <button class="btn btn-primary" type="submit">{{ $submitLabel ?? 'Guardar' }}</button>
</div>