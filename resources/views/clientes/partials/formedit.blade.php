@php
    $cliente = $cliente ?? null;
@endphp

<div class="form-grid">
    <div class="field">
        <label for="nombre_completo">Nombre completo</label>
        <input class="input" type="text" id="nombre_completo" name="nombre_completo" maxlength="100" value="{{ old('nombre_completo', optional($cliente)->nombre_completo) }}" required>
    </div>

    <div class="field">
        <label for="razon_social">Razon social</label>
        <input class="input" type="text" id="razon_social" name="razon_social" maxlength="150" value="{{ old('razon_social', optional($cliente)->razon_social) }}" required>
    </div>

    <div class="field">
        <label for="tipo_documento">Tipo de documento</label>
        <select class="select" id="tipo_documento" name="tipo_documento" required>
            @foreach (['CI', 'NIT', 'Pasaporte', 'Otro'] as $tipo)
                <option value="{{ $tipo }}" @selected(old('tipo_documento', optional($cliente)->tipo_documento ?? 'CI') === $tipo)>
                    {{ $tipo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label for="numero_documento">Numero de documento</label>
        <input class="input" type="text" id="numero_documento" name="numero_documento" maxlength="50" value="{{ old('numero_documento', optional($cliente)->numero_documento) }}">
    </div>

    <div class="field">
        <label for="telefono">Telefono</label>
        <input class="input" type="text" id="telefono" name="telefono" maxlength="20" value="{{ old('telefono', optional($cliente)->telefono) }}">
    </div>

    <div class="field">
        <label for="email">Correo</label>
        <input class="input" type="email" id="email" name="email" maxlength="100" value="{{ old('email', optional($cliente)->email) }}">
    </div>

    <div class="field">
        <label for="direccion">Direccion</label>
        <textarea class="textarea" id="direccion" name="direccion">{{ old('direccion', optional($cliente)->direccion) }}</textarea>
    </div>

    <div class="field">
        <label for="activo">Estado</label>
        <select class="select" id="activo" name="activo" required>
            <option value="1" @selected((string) old('activo', optional($cliente)->activo ?? '1') === '1')>Activo</option>
            <option value="0" @selected((string) old('activo', optional($cliente)->activo) === '0')>Inactivo</option>
        </select>
    </div>
</div>

<div class="form-actions">
    <a class="btn btn-light" href="{{ route('clientes.index') }}">Cancelar</a>
    <button class="btn btn-primary" type="submit">{{ $submitLabel ?? 'Guardar' }}</button>
</div>