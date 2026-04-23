@extends('layouts.app')

@section('title', 'Proveedores')
@section('page-title', 'Gestion de proveedores')

@section('content')
    <x-ui.table-card title="Proveedores" subtitle="Administracion de proveedores para proceso de compras">
        <x-slot name="actions">
            <a class="btn btn-primary" href="{{ route('proveedores.create') }}">Nuevo proveedor</a>
        </x-slot>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Razon social</th>
                        <th>Contacto</th>
                        <th>Documento</th>
                        <th>Correo / Telefono</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->razon_social }}</td>
                            <td>{{ $proveedor->nombre_contacto ?: '-' }}</td>
                            <td>{{ $proveedor->tipo_documento }} {{ $proveedor->numero_documento ? '- ' . $proveedor->numero_documento : '' }}</td>
                            <td>
                                <div>{{ $proveedor->email ?: '-' }}</div>
                                <div>{{ $proveedor->telefono ?: '-' }}</div>
                            </td>
                            <td>
                                <span class="status-pill {{ $proveedor->activo ? 'active' : 'inactive' }}">
                                    {{ $proveedor->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-inline">
                                    <a class="btn btn-light" href="{{ route('proveedores.edit', $proveedor) }}">Editar</a>
                                    <form method="POST" action="{{ route('proveedores.destroy', $proveedor) }}" onsubmit="return confirm('Deseas eliminar este proveedor?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay proveedores registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $proveedores->links() }}
        </div>
    </x-ui.table-card>
@endsection
