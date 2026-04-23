@php
    $marca = $marca ?? null;
@endphp

<div class="form-grid">
    <div class="field">
        <label for="nombre_marca">Nombre</label>
        <input
            class="input"
            type="text"
            id="nombre_marca"
            name="nombre_marca"
            maxlength="100"
            value="{{ old('nombre_marca', optional($marca)->nombre_marca) }}"
            required
        >
    </div>

    <div class="field">
        <label for="descripcion">Descripcion</label>
        <textarea class="textarea" id="descripcion" name="descripcion">{{ old('descripcion', optional($marca)->descripcion) }}</textarea>
    </div>

    <div class="field">
        <label for="estado">Estado</label>
        <select class="select" id="estado" name="estado" required>
            <option value="1" @selected((string) old('estado', optional($marca)->estado ?? '1') === '1')>Activa</option>
            <option value="0" @selected((string) old('estado', optional($marca)->estado) === '0')>Inactiva</option>
        </select>
    </div>
</div>

<div class="form-actions">
    <a class="btn btn-light" href="{{ route('marcas.index') }}">Cancelar</a>
    <button class="btn btn-primary" type="submit">{{ $submitLabel ?? 'Guardar' }}</button>
</div>