@php
    $metodoPago = $metodoPago ?? null;
@endphp

<div class="form-grid">
    <div class="field">
        <label for="nombre_metodo">Nombre del metodo</label>
        <input
            class="input"
            type="text"
            id="nombre_metodo"
            name="nombre_metodo"
            maxlength="50"
            value="{{ old('nombre_metodo', optional($metodoPago)->nombre_metodo) }}"
            required
        >
    </div>
</div>

<div class="form-actions">
    <a class="btn btn-light" href="{{ route('metodos-pago.index') }}">Cancelar</a>
    <button class="btn btn-primary" type="submit">{{ $submitLabel ?? 'Guardar' }}</button>
</div>