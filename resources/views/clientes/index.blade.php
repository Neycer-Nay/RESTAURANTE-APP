@extends('layouts.app')

@section('title', 'Clientes')
@section('page-title', 'Gestion de clientes')

@section('content')
    <x-ui.table-card title="Clientes" subtitle="Listado de clientes para proceso de ventas">
        <x-slot name="actions">
            <a class="btn btn-primary" href="{{ route('clientes.create') }}">Nuevo cliente</a>
        </x-slot>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre completo</th>
                        <th>Razon social</th>
                        <th>Documento</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nombre_completo }}</td>
                            <td>{{ $cliente->razon_social }}</td>
                            <td>{{ $cliente->tipo_documento }} {{ $cliente->numero_documento ? '- ' . $cliente->numero_documento : '' }}</td>
                            <td>
                                <div>{{ $cliente->telefono ?: '-' }}</div>
                                <div>{{ $cliente->email ?: '-' }}</div>
                            </td>
                            <td>
                                <span class="status-pill {{ $cliente->activo ? 'active' : 'inactive' }}">
                                    {{ $cliente->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-inline">
                                    <a class="btn btn-light" href="{{ route('clientes.edit', $cliente) }}">Editar</a>
                                    <form method="POST" action="{{ route('clientes.destroy', $cliente) }}" onsubmit="return confirm('Deseas eliminar este cliente?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay clientes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $clientes->links() }}
        </div>
    </x-ui.table-card>
@endsection
