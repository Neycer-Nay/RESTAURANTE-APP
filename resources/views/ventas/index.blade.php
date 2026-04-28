@extends('layouts.app')

@section('title', 'Ventas')
@section('page-title', 'Gestion de ventas')

@section('content')
    <x-ui.table-card title="Ventas" subtitle="Listado con filtros">
        <x-slot name="actions">
            <a class="btn btn-primary" href="{{ route('ventas.create') }}">Nueva venta</a>
        </x-slot>

        <form method="GET" action="{{ route('ventas.index') }}" style="margin-bottom:16px;">
            <div class="form-grid" style="grid-template-columns: repeat(4, 1fr) auto; align-items:end; gap:10px;">
                <div class="field">
                    <label>Desde</label>
                    <input type="date" name="fecha_desde" class="input" value="{{ request('fecha_desde') }}">
                </div>
                <div class="field">
                    <label>Hasta</label>
                    <input type="date" name="fecha_hasta" class="input" value="{{ request('fecha_hasta') }}">
                </div>
                <div class="field">
                    <label>Usuario</label>
                    <select name="id_usuario" class="select">
                        <option value="">Todos</option>
                        @foreach ($usuarios as $u)
                            <option value="{{ $u->id }}" {{ request('id_usuario') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Cliente</label>
                    <select name="id_cliente" class="select">
                        <option value="">Todos</option>
                        @foreach ($clientes as $c)
                            <option value="{{ $c->id }}" {{ request('id_cliente') == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('ventas.index') }}" class="btn btn-light">Limpiar</a>
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
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->id }}</td>
                            <td>{{ $venta->fecha_venta?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td>{{ $venta->usuario?->name ?? '-' }}</td>
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
                            <td colspan="7">No hay ventas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $ventas->links() }}
        </div>
    </x-ui.table-card>
@endsection

