@php
    $producto = $producto ?? null;
    $inventario = optional($producto)->inventario;
@endphp

<div class="form-grid">
    <div class="field">
        <label for="nombre_producto">Nombre del producto</label>
        <input class="input" type="text" id="nombre_producto" name="nombre_producto" maxlength="150" value="{{ old('nombre_producto', optional($producto)->nombre_producto) }}" required>
    </div>

    <div class="field">
        <label for="descripcion">Descripcion</label>
        <textarea class="textarea" id="descripcion" name="descripcion">{{ old('descripcion', optional($producto)->descripcion) }}</textarea>
    </div>

    <div class="field">
        <label for="precio_compra">Precio de compra</label>
        <input class="input" type="number" step="0.01" min="0" id="precio_compra" name="precio_compra" value="{{ old('precio_compra', optional($producto)->precio_compra) }}" required>
    </div>

    <div class="field">
        <label for="precio_venta">Precio de venta</label>
        <input class="input" type="number" step="0.01" min="0" id="precio_venta" name="precio_venta" value="{{ old('precio_venta', optional($producto)->precio_venta) }}" required>
    </div>

    <div class="field">
        <label for="tipo_producto">Tipo de producto</label>
        <select class="select" id="tipo_producto" name="tipo_producto" required>
            <option value="almacenable" @selected(old('tipo_producto', optional($producto)->tipo_producto ?? 'almacenable') === 'almacenable')>Almacenable</option>
            <option value="elaborado" @selected(old('tipo_producto', optional($producto)->tipo_producto) === 'elaborado')>Elaborado</option>
        </select>
    </div>

    <div class="field">
        <label for="id_categoria">Categoria</label>
        <select class="select" id="id_categoria" name="id_categoria">
            <option value="">Sin categoria</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}" @selected((string) old('id_categoria', optional($producto)->id_categoria) === (string) $categoria->id)>
                    {{ $categoria->nombre_categoria }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label for="id_marca">Marca</label>
        <select class="select" id="id_marca" name="id_marca">
            <option value="">Sin marca</option>
            @foreach ($marcas as $marca)
                <option value="{{ $marca->id }}" @selected((string) old('id_marca', optional($producto)->id_marca) === (string) $marca->id)>
                    {{ $marca->nombre_marca }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label for="cantidad_minima">Stock minimo</label>
        <input class="input" type="number" min="0" id="cantidad_minima" name="cantidad_minima" value="{{ old('cantidad_minima', optional($inventario)->cantidad_minima ?? 0) }}" required>
    </div>

    <div class="field">
        <label for="cantidad_maxima">Stock maximo</label>
        <input class="input" type="number" min="0" id="cantidad_maxima" name="cantidad_maxima" value="{{ old('cantidad_maxima', optional($inventario)->cantidad_maxima ?? 0) }}" required>
    </div>

    <div class="field">
        <label for="activo">Estado</label>
        <select class="select" id="activo" name="activo" required>
            <option value="1" @selected((string) old('activo', optional($producto)->activo ?? '1') === '1')>Activo</option>
            <option value="0" @selected((string) old('activo', optional($producto)->activo) === '0')>Inactivo</option>
        </select>
    </div>

    @if ($producto)
        <div class="field">
            <label>Stock actual</label>
            <input class="input" type="text" value="{{ $inventario?->cantidad_actual ?? 0 }}" disabled>
        </div>
    @endif
</div>

<div class="form-actions">
    <a class="btn btn-light" href="{{ route('productos.index') }}">Cancelar</a>
    <button class="btn btn-primary" type="submit">{{ $submitLabel ?? 'Guardar' }}</button>
</div>