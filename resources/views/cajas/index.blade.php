@extends('layouts.app')

@section('title', 'Cajas')
@section('page-title', 'Gestion de cajas')

@section('content')
    <x-ui.table-card title="Cajas" subtitle="Listado de aperturas y cierres diarios">
        <x-slot name="actions">
            <a class="btn btn-primary" href="{{ route('cajas.create') }}">Abrir caja</a>
        </x-slot>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Apertura</th>
                        <th>Cierre</th>
                        <th>Monto apertura</th>
                        <th>Monto cierre</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cajas as $caja)
                        <tr>
                            <td>{{ $caja->id }}</td>
                            <td>{{ $caja->usuario?->name ?? '-' }}</td>
                            <td>{{ $caja->fecha_apertura?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td>{{ $caja->fecha_cierre?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td>{{ number_format($caja->monto_apertura, 2) }}</td>
                            <td>{{ $caja->monto_cierre ? number_format($caja->monto_cierre, 2) : '-' }}</td>
                            <td>
                                <span class="status-pill {{ $caja->estado_caja === 'abierta' ? 'active' : 'inactive' }}">
                                    {{ ucfirst($caja->estado_caja) }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-inline">
                                    <a class="btn btn-light" href="{{ route('cajas.show', $caja) }}">Ver</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No hay cajas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $cajas->links() }}
        </div>
    </x-ui.table-card>
@endsection

