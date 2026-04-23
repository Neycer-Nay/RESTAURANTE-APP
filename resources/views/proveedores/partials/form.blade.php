@php
    $proveedor = $proveedor ?? null;
@endphp

<div class="form-grid">
    <div class="field">
        <label for="razon_social">Razon social</label>
        <input class="input" type="text" id="razon_social" name="razon_social" maxlength="150" value="{{ old('razon_social', optional($proveedor)->razon_social) }}" required>
    </div>

    <div class="field">
        <label for="nombre_contacto">Nombre de contacto</label>
        <input class="input" type="text" id="nombre_contacto" name="nombre_contacto" maxlength="100" value="{{ old('nombre_contacto', optional($proveedor)->nombre_contacto) }}">
    </div>

    <div class="field">
        <label for="tipo_documento">Tipo de documento</label>
        <select class="select" id="tipo_documento" name="tipo_documento" required>
            @foreach (['CI', 'NIT', 'Pasaporte', 'Otro'] as $tipo)
                <option value="{{ $tipo }}" @selected(old('tipo_documento', optional($proveedor)->tipo_documento ?? 'NIT') === $tipo)>
                    {{ $tipo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label for="numero_documento">Numero de documento</label>
        <input class="input" type="text" id="numero_documento" name="numero_documento" maxlength="50" value="{{ old('numero_documento', optional($proveedor)->numero_documento) }}">
    </div>

    <div class="field">
        <label for="telefono">Telefono</label>
        <input class="input" type="text" id="telefono" name="telefono" maxlength="20" value="{{ old('telefono', optional($proveedor)->telefono) }}">
    </div>

    <div class="field">
        <label for="email">Correo</label>
        <input class="input" type="email" id="email" name="email" maxlength="100" value="{{ old('email', optional($proveedor)->email) }}">
    </div>

    <div class="field">
        <label for="direccion">Direccion</label>
        <textarea class="textarea" id="direccion" name="direccion">{{ old('direccion', optional($proveedor)->direccion) }}</textarea>
    </div>

    <div class="field">
        <label for="activo">Estado</label>
        <select class="select" id="activo" name="activo" required>
            <option value="1" @selected((string) old('activo', optional($proveedor)->activo ?? '1') === '1')>Activo</option>
            <option value="0" @selected((string) old('activo', optional($proveedor)->activo) === '0')>Inactivo</option>
        </select>
    </div>
</div>

<div class="form-actions">
    <a class="btn btn-light" href="{{ route('proveedores.index') }}">Cancelar</a>
    <button class="btn btn-primary" type="submit">{{ $submitLabel ?? 'Guardar' }}</button>
</div>