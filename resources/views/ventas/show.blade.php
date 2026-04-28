@extends('layouts.app')

@section('title', 'Detalle de venta')
@section('page-title', 'Venta #' . $venta->id)

@section('content')
    <x-ui.table-card title="Informacion de venta" subtitle="Resumen general">
        <x-slot name="actions">
            <a class="btn btn-light" href="{{ route('ventas.index') }}">Volver</a>
            @if ($venta->estado)
                <form method="POST" action="{{ route('ventas.anular', $venta) }}"
                    style="display:inline;"
                    onsubmit="return confirm('¿Esta seguro de anular esta venta? Se reversara el stock y el movimiento de caja.');"
                >
                    @csrf
                    <button type="submit" class="btn btn-danger">Anular venta</button>
                </form>
            @endif
        </x-slot>

        <div class="form-grid" style="grid-template-columns: repeat(4, 1fr);">
            <div class="field">
                <label>Caja</label>
                <div class="input" style="background:#f8fafc">#{{ $venta->caja->id }} ({{ ucfirst($venta->caja->estado_caja) }})</div>
            </div>
            <div class="field">
                <label>Usuario</label>
                <div class="input" style="background:#f8fafc">{{ $venta->usuario?->name ?? '-' }}</div>
            </div>
            <div class="field">
                <label>Cliente</label>
                <div class="input" style="background:#f8fafc">{{ $venta->cliente?->nombre_completo ?? 'Sin cliente' }}</div>
            </div>
            <div class="field">
                <label>Fecha</label>
                <div class="input" style="background:#f8fafc">{{ $venta->fecha_venta?->format('d/m/Y H:i') ?? '-' }}</div>
            </div>
            <div class="field">
                <label>Subtotal</label>
                <div class="input" style="background:#f8fafc">{{ number_format($venta->subtotal, 2) }}</div>
            </div>
            <div class="field">
                <label>Total</label>
                <div class="input" style="background:#f8fafc">{{ number_format($venta->total, 2) }}</div>
            </div>
            <div class="field">
                <label>Estado</label>
                <div class="input" style="background:#f8fafc">
                    <span class="status-pill {{ $venta->estado ? 'active' : 'inactive' }}">
                        {{ $venta->estado ? 'Activa' : 'Anulada' }}
                    </span>
                </div>
            </div>
        </div>
    </x-ui.table-card>

    <x-ui.table-card title="Detalle de productos" subtitle="Items vendidos">
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
                    @foreach ($venta->detallesVenta as $detalle)
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

    <x-ui.table-card title="Pagos recibidos" subtitle="Metodos de pago utilizados">
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
                    @foreach ($venta->pagosVenta as $pago)
                        <tr>
                            <td>{{ $pago->metodoPago?->nombre_metodo ?? '-' }}</td>
                            <td>{{ number_format($pago->monto, 2) }}</td>
                            <td>{{ $pago->referencia ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-ui.table-card>
@endsection

