@extends('layouts.app')

@section('title', 'Marcas')
@section('page-title', 'Gestion de marcas')

@section('content')
    <x-ui.table-card title="Marcas" subtitle="Administra las marcas de los productos">
        <x-slot name="actions">
            <a class="btn btn-primary" href="{{ route('marcas.create') }}">Nueva marca</a>
        </x-slot>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($marcas as $marca)
                        <tr>
                            <td>{{ $marca->nombre_marca }}</td>
                            <td>{{ $marca->descripcion ?: '-' }}</td>
                            <td>
                                <span class="status-pill {{ $marca->estado ? 'active' : 'inactive' }}">
                                    {{ $marca->estado ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td>{{ $marca->productos_count }}</td>
                            <td>
                                <div class="actions-inline">
                                    <a class="btn btn-light" href="{{ route('marcas.edit', $marca) }}">Editar</a>
                                    <form method="POST" action="{{ route('marcas.destroy', $marca) }}" onsubmit="return confirm('Deseas eliminar esta marca?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay marcas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $marcas->links() }}
        </div>
    </x-ui.table-card>
@endsection
