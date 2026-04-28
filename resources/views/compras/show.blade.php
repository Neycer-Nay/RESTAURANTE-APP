@extends('layouts.app')

@section('title', 'Detalle de compra')
@section('page-title', 'Compra #' . $compra->id)

@section('content')
    <x-ui.table-card title="Informacion de compra" subtitle="Resumen general">
        <x-slot name="actions">
            <a class="btn btn-light" href="{{ route('compras.index') }}">Volver</a>
        </x-slot>

        <div class="form-grid" style="grid-template-columns: repeat(4, 1fr);">
            <div class="field">
                <label>Caja</label>
                <div class="input" style="background:#f8fafc">#{{ $compra->caja->id }} ({{ ucfirst($compra->caja->estado_caja) }})</div>
            </div>
            <div class="field">
                <label>Usuario</label>
                <div class="input" style="background:#f8fafc">{{ $compra->usuario?->name ?? '-' }}</div>
            </div>
            <div class="field">
                <label>Proveedor</label>
                <div class="input" style="background:#f8fafc">{{ $compra->proveedor?->razon_social ?? 'Sin proveedor' }}</div>
            </div>
            <div class="field">
                <label>Fecha</label>
                <div class="input" style="background:#f8fafc">{{ $compra->fecha_compra?->format('d/m/Y H:i') ?? '-' }}</div>
            </div>
            <div class="field">
                <label>Subtotal</label>
                <div class="input" style="background:#f8fafc">{{ number_format($compra->subtotal, 2) }}</div>
            </div>
            <div class="field">
                <label>Total</label>
                <div class="input" style="background:#f8fafc">{{ number_format($compra->total, 2) }}</div>
            </div>
            <div class="field">
                <label>Estado</label>
                <div class="input" style="background:#f8fafc">
                    <span class="status-pill {{ $compra->estado ? 'active' : 'inactive' }}">
                        {{ $compra->estado ? 'Activa' : 'Anulada' }}
                    </span>
                </div>
            </div>
        </div>
    </x-ui.table-card>

    <x-ui.table-card title="Detalle de productos" subtitle="Items comprados">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compra->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->producto?->nombre_producto ?? '-' }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>{{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td>{{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-ui.table-card>

    <x-ui.table-card title="Pagos realizados" subtitle="Metodos de pago utilizados">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Metodo</th>
                        <th>Monto</th>
                        <th>Referencia</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($compra->pagosCompra as $pago)
                        <tr>
                            <td>{{ $pago->metodoPago?->nombre_metodo ?? '-' }}</td>
                            <td>{{ number_format($pago->monto, 2) }}</td>
                            <td>{{ $pago->referencia ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Sin pagos registrados (compra a credito).</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.table-card>
@endsection

