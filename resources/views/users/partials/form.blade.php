@php
    $user = $user ?? null;
    $isEdit = $isEdit ?? false;
@endphp

<div class="form-grid">
    <div class="field">
        <label for="name">Nombre</label>
        <input
            class="input"
            type="text"
            id="name"
            name="name"
            maxlength="255"
            value="{{ old('name', optional($user)->name) }}"
            required
        >
    </div>

    <div class="field">
        <label for="email">Correo</label>
        <input
            class="input"
            type="email"
            id="email"
            name="email"
            maxlength="255"
            value="{{ old('email', optional($user)->email) }}"
            required
        >
    </div>

    <div class="field">
        <label for="id_rol">Rol</label>
        <select class="select" id="id_rol" name="id_rol">
            <option value="">Sin rol asignado</option>
            @foreach ($roles as $role)
                <option
                    value="{{ $role->id }}"
                    @selected((string) old('id_rol', optional($user)->id_rol) === (string) $role->id)
                >
                    {{ $role->nombre_rol }}
                </option>
            @endforeach
        </select>
    </div>

    {{--  <div class="field">
        <label for="activo">Estado</label>
        <select class="select" id="activo" name="activo" required>
            <option value="1" @selected((string) old('activo', optional($user)->activo ?? '1') === '1')>Activo</option>
            <option value="0" @selected((string) old('activo', optional($user)->activo) === '0')>Inactivo</option>
        </select>
    </div>--}}

    <div class="field">
        <label for="password">Contrasena {{ $isEdit ? '(opcional)' : '' }}</label>
        <input class="input" type="password" id="password" name="password" {{ $isEdit ? '' : 'required' }}>
    </div>

    <div class="field">
        <label for="password_confirmation">Confirmar contrasena</label>
        <input class="input" type="password" id="password_confirmation" name="password_confirmation" {{ $isEdit ? '' : 'required' }}>
    </div>
</div>

<div class="form-actions">
    <a class="btn btn-light" href="{{ route('users.index') }}">Cancelar</a>
    <button class="btn btn-primary" type="submit">{{ $submitLabel ?? 'Guardar' }}</button>
</div>
