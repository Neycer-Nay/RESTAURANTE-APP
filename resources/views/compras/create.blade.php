@extends('layouts.app')

@section('title', 'Nueva compra')
@section('page-title', 'Nueva compra')

@section('content')
    @if (! $cajaAbierta)
        <x-ui.form-card title="Caja cerrada" subtitle="No puedes realizar compras">
            <div class="alert alert-error">
                No tienes una caja abierta. <a href="{{ route('cajas.create') }}">Abrir caja</a>.
            </div>
        </x-ui.form-card>
    @else
        <form id="compra-form" method="POST" action="{{ route('compras.store') }}">
            @csrf

            <x-ui.form-card title="Datos de compra" subtitle="Proveedor y productos">
                <div class="form-grid" style="grid-template-columns: 1fr;">
                    <div class="field">
                        <label>Proveedor (opcional)</label>
                        <select name="id_proveedor" class="select">
                            <option value="">-- Sin proveedor --</option>
                            @foreach ($proveedores as $p)
                                <option value="{{ $p->id }}" {{ old('id_proveedor') == $p->id ? 'selected' : '' }}>
                                    {{ $p->razon_social }} ({{ $p->tipo_documento }} {{ $p->numero_documento }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr style="border:none;border-top:1px solid var(--line);margin:16px 0;">

                <h3 style="margin:0 0 10px;font-size:16px;">Productos</h3>

                <div class="table-wrap">
                    <table class="table" id="productos-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio unit.</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="productos-body">
                            {{-- filas dinamicas --}}
                        </tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-light" id="btn-add-producto">+ Agregar producto</button>

                <div style="text-align:right;margin-top:10px;font-size:18px;font-weight:700;">
                    Total: <span id="total-compra">0.00</span>
                </div>
            </x-ui.form-card>

            <x-ui.form-card title="Pagos" subtitle="Metodos de pago (opcional para compras a credito)">
                <div class="table-wrap">
                    <table class="table" id="pagos-table">
                        <thead>
                            <tr>
                                <th>Metodo</th>
                                <th>Monto</th>
                                <th>Referencia</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="pagos-body">
                            {{-- filas dinamicas --}}
                        </tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-light" id="btn-add-pago">+ Agregar pago</button>

                <div style="text-align:right;margin-top:10px;font-size:16px;font-weight:700;">
                    Total pagos: <span id="total-pagos">0.00</span>
                </div>
            </x-ui.form-card>

            <div class="form-actions">
                <a href="{{ route('compras.index') }}" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary" id="btn-guardar">Guardar compra</button>
            </div>
        </form>

        <template id="tpl-producto">
            <tr class="producto-row">
                <td>
                    <select name="productos[IDX][id_producto]" class="select producto-select" required>
                        <option value="">-- Seleccione --</option>
                        @foreach ($productos as $p)
                            <option value="{{ $p->id }}" data-precio="{{ $p->precio_compra }}">
                                {{ $p->nombre_producto }} (Stock: {{ $p->inventario?->cantidad_actual ?? 0 }})
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="productos[IDX][cantidad]" class="input cantidad-input" min="1" value="1" required>
                </td>
                <td>
                    <input type="number" step="0.01" name="productos[IDX][precio_unitario]" class="input precio-input" min="0" value="0" required>
                </td>
                <td class="subtotal-cell">0.00</td>
                <td>
                    <button type="button" class="btn btn-danger btn-remove-row">Eliminar</button>
                </td>
            </tr>
        </template>

        <template id="tpl-pago">
            <tr class="pago-row">
                <td>
                    <select name="pagos[IDX][id_metodo_pago]" class="select" required>
                        <option value="">-- Seleccione --</option>
                        @foreach ($metodosPago as $m)
                            <option value="{{ $m->id }}">{{ $m->nombre_metodo }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" step="0.01" name="pagos[IDX][monto]" class="input pago-monto" min="0" value="0" required>
                </td>
                <td>
                    <input type="text" name="pagos[IDX][referencia]" class="input" placeholder="Opcional" maxlength="100">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-remove-row">Eliminar</button>
                </td>
            </tr>
        </template>

        <script>
            (function () {
                let prodIndex = 0;
                let pagoIndex = 0;

                const productosBody = document.getElementById('productos-body');
                const pagosBody = document.getElementById('pagos-body');
                const tplProducto = document.getElementById('tpl-producto').innerHTML;
                const tplPago = document.getElementById('tpl-pago').innerHTML;
                const totalCompraEl = document.getElementById('total-compra');
                const totalPagosEl = document.getElementById('total-pagos');
                const btnGuardar = document.getElementById('btn-guardar');

                function calcularTotales() {
                    let total = 0;
                    document.querySelectorAll('.producto-row').forEach(function (row) {
                        const cantidad = parseFloat(row.querySelector('.cantidad-input').value) || 0;
                        const precio = parseFloat(row.querySelector('.precio-input').value) || 0;
                        const subtotal = cantidad * precio;
                        row.querySelector('.subtotal-cell').textContent = subtotal.toFixed(2);
                        total += subtotal;
                    });
                    totalCompraEl.textContent = total.toFixed(2);

                    let totalPagos = 0;
                    document.querySelectorAll('.pago-row').forEach(function (row) {
                        totalPagos += parseFloat(row.querySelector('.pago-monto').value) || 0;
                    });
                    totalPagosEl.textContent = totalPagos.toFixed(2);

                    const hayPagos = document.querySelectorAll('.pago-row').length > 0;

                    if (hayPagos && Math.abs(total - totalPagos) > 0.01) {
                        btnGuardar.disabled = true;
                        btnGuardar.textContent = 'Los pagos no coinciden con el total';
                    } else if (total <= 0) {
                        btnGuardar.disabled = true;
                        btnGuardar.textContent = 'Agregue al menos un producto';
                    } else {
                        btnGuardar.disabled = false;
                        btnGuardar.textContent = 'Guardar compra';
                    }
                }

                function addProducto() {
                    const html = tplProducto.replace(/IDX/g, prodIndex);
                    const wrapper = document.createElement('tbody');
                    wrapper.innerHTML = html;
                    const row = wrapper.firstElementChild;
                    productosBody.appendChild(row);

                    row.querySelector('.producto-select').addEventListener('change', function () {
                        const option = this.options[this.selectedIndex];
                        const precio = option.getAttribute('data-precio') || 0;
                        row.querySelector('.precio-input').value = parseFloat(precio).toFixed(2);
                        calcularTotales();
                    });

                    row.querySelector('.cantidad-input').addEventListener('input', calcularTotales);
                    row.querySelector('.precio-input').addEventListener('input', calcularTotales);
                    row.querySelector('.btn-remove-row').addEventListener('click', function () {
                        row.remove();
                        calcularTotales();
                    });

                    prodIndex++;
                    calcularTotales();
                }

                function addPago() {
                    const html = tplPago.replace(/IDX/g, pagoIndex);
                    const wrapper = document.createElement('tbody');
                    wrapper.innerHTML = html;
                    const row = wrapper.firstElementChild;
                    pagosBody.appendChild(row);

                    row.querySelector('.pago-monto').addEventListener('input', calcularTotales);
                    row.querySelector('.btn-remove-row').addEventListener('click', function () {
                        row.remove();
                        calcularTotales();
                    });

                    pagoIndex++;
                    calcularTotales();
                }

                document.getElementById('btn-add-producto').addEventListener('click', addProducto);
                document.getElementById('btn-add-pago').addEventListener('click', addPago);

                // agregar una fila inicial
                addProducto();
            })();
        </script>
    @endif
@endsection

