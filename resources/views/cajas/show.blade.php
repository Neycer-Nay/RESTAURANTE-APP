@extends('layouts.app')

@section('title', 'Detalle de caja')
@section('page-title', 'Caja #' . $caja->id)

@section('content')
    <x-ui.table-card title="Informacion de caja" subtitle="Resumen de apertura y estado">
        <x-slot name="actions">
            <a class="btn btn-light" href="{{ route('cajas.index') }}">Volver</a>
        </x-slot>

        <div class="form-grid" style="grid-template-columns: repeat(3, 1fr);">
            <div class="field">
                <label>Usuario</label>
                <div class="input" style="background:#f8fafc">{{ $caja->usuario?->name ?? '-' }}</div>
            </div>
            <div class="field">
                <label>Fecha apertura</label>
                <div class="input" style="background:#f8fafc">{{ $caja->fecha_apertura?->format('d/m/Y H:i') ?? '-' }}</div>
            </div>
            <div class="field">
                <label>Fecha cierre</label>
                <div class="input" style="background:#f8fafc">{{ $caja->fecha_cierre?->format('d/m/Y H:i') ?? '-' }}</div>
            </div>
            <div class="field">
                <label>Monto apertura</label>
                <div class="input" style="background:#f8fafc">{{ number_format($caja->monto_apertura, 2) }}</div>
            </div>
            <div class="field">
                <label>Monto cierre</label>
                <div class="input" style="background:#f8fafc">{{ $caja->monto_cierre ? number_format($caja->monto_cierre, 2) : '-' }}</div>
            </div>
            <div class="field">
                <label>Estado</label>
                <div class="input" style="background:#f8fafc">
                    <span class="status-pill {{ $caja->estado_caja === 'abierta' ? 'active' : 'inactive' }}">
                        {{ ucfirst($caja->estado_caja) }}
                    </span>
                </div>
            </div>
        </div>

        @if ($caja->estado_caja === 'abierta')
            <hr style="border:none;border-top:1px solid var(--line);margin:18px 0;">
            <form method="POST" action="{{ route('cajas.cerrar', $caja) }}">
                @csrf
                <div class="form-grid" style="grid-template-columns: 1fr auto;align-items:end;gap:12px;">
                    <div class="field">
                        <label>Monto de cierre</label>
                        <input type="number" step="0.01" min="0" name="monto_cierre" class="input"
                            value="{{ old('monto_cierre') }}" required>
                        @error('monto_cierre')
                            <p style="color:#b91c1c;font-size:13px;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-danger">Cerrar caja</button>
                    </div>
                </div>
            </form>
        @endif
    </x-ui.table-card>

    <x-ui.table-card title="Movimientos de caja" subtitle="Ingresos y salidas registrados">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Concepto</th>
                        <th>Monto</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($caja->movimientos as $mov)
                        <tr>
                            <td>{{ $mov->fecha_movimiento?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td>
                                <span class="status-pill {{ $mov->tipo_movimiento === 'ingreso' ? 'active' : 'inactive' }}">
                                    {{ ucfirst($mov->tipo_movimiento) }}
                                </span>
                            </td>
                            <td>{{ $mov->concepto }}</td>
                            <td>{{ number_format($mov->monto, 2) }}</td>
                            <td>{{ $mov->usuario?->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay movimientos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.table-card>

    <x-ui.table-card title="Ventas en caja" subtitle="Ventas asociadas a esta caja">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($caja->ventas as $venta)
                        <tr>
                            <td>{{ $venta->id }}</td>
                            <td>{{ $venta->fecha_venta?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td>{{ $venta->cliente?->nombre_completo ?? 'Sin cliente' }}</td>
                            <td>{{ number_format($venta->total, 2) }}</td>
                            <td>
                                <span class="status-pill {{ $venta->estado ? 'active' : 'inactive' }}">
                                    {{ $venta->estado ? 'Activa' : 'Anulada' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-inline">
                                    <a class="btn btn-light" href="{{ route('ventas.show', $venta) }}">Ver</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay ventas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.table-card>
@endsection

