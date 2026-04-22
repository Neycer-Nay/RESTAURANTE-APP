@php
    $role = $role ?? null;
@endphp

<div class="form-grid">
    <div class="field">
        <label for="nombre_rol">Nombre del rol</label>
        <input
            class="input"
            type="text"
            id="nombre_rol"
            name="nombre_rol"
            maxlength="50"
            value="{{ old('nombre_rol', optional($role)->nombre_rol) }}"
            required
        >
    </div>

    <div class="field">
        <label for="descripcion">Descripcion</label>
        <textarea class="textarea" id="descripcion" name="descripcion">{{ old('descripcion', optional($role)->descripcion) }}</textarea>
    </div>
</div>

<div class="form-actions">
    <a class="btn btn-light" href="{{ route('roles.index') }}">Cancelar</a>
    <button class="btn btn-primary" type="submit">{{ $submitLabel ?? 'Guardar' }}</button>
</div>
