@extends('layouts.app')

@section('title', 'Compras')
@section('page-title', 'Gestion de compras')

@section('content')
    <x-ui.table-card title="Compras" subtitle="Listado con filtros">
        <x-slot name="actions">
            <a class="btn btn-primary" href="{{ route('compras.create') }}">Nueva compra</a>
        </x-slot>

        <form method="GET" action="{{ route('compras.index') }}" style="margin-bottom:16px;">
            <div class="form-grid" style="grid-template-columns: repeat(3, 1fr) auto; align-items:end; gap:10px;">
                <div class="field">
                    <label>Desde</label>
                    <input type="date" name="fecha_desde" class="input" value="{{ request('fecha_desde') }}">
                </div>
                <div class="field">
                    <label>Hasta</label>
                    <input type="date" name="fecha_hasta" class="input" value="{{ request('fecha_hasta') }}">
                </div>
                <div class="field">
                    <label>Proveedor</label>
                    <select name="id_proveedor" class="select">
                        <option value="">Todos</option>
                        @foreach ($proveedores as $p)
                            <option value="{{ $p->id }}" {{ request('id_proveedor') == $p->id ? 'selected' : '' }}>
                                {{ $p->razon_social }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('compras.index') }}" class="btn btn-light">Limpiar</a>
                </div>
            </div>
        </form>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Proveedor</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($compras as $compra)
                        <tr>
                            <td>{{ $compra->id }}</td>
                            <td>{{ $compra->fecha_compra?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td>{{ $compra->usuario?->name ?? '-' }}</td>
                            <td>{{ $compra->proveedor?->razon_social ?? 'Sin proveedor' }}</td>
                            <td>{{ number_format($compra->total, 2) }}</td>
                            <td>
                                <span class="status-pill {{ $compra->estado ? 'active' : 'inactive' }}">
                                    {{ $compra->estado ? 'Activa' : 'Anulada' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-inline">
                                    <a class="btn btn-light" href="{{ route('compras.show', $compra) }}">Ver</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay compras registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $compras->links() }}
        </div>
    </x-ui.table-card>
@endsection

