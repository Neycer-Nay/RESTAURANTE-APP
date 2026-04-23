@extends('layouts.app')

@section('title', 'Metodos de pago')
@section('page-title', 'Gestion de metodos de pago')

@section('content')
    <x-ui.table-card title="Metodos de pago" subtitle="Gestion de medios de pago para ventas y compras">
        <x-slot name="actions">
            <a class="btn btn-primary" href="{{ route('metodos-pago.create') }}">Nuevo metodo</a>
        </x-slot>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Pagos venta</th>
                        <th>Pagos compra</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($metodosPago as $metodoPago)
                        <tr>
                            <td>{{ $metodoPago->nombre_metodo }}</td>
                            <td>{{ $metodoPago->pagos_venta_count }}</td>
                            <td>{{ $metodoPago->pagos_compra_count }}</td>
                            <td>
                                <div class="actions-inline">
                                    <a class="btn btn-light" href="{{ route('metodos-pago.edit', $metodoPago) }}">Editar</a>
                                    <form method="POST" action="{{ route('metodos-pago.destroy', $metodoPago) }}" onsubmit="return confirm('Deseas eliminar este metodo de pago?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No hay metodos de pago registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $metodosPago->links() }}
        </div>
    </x-ui.table-card>
@endsection
