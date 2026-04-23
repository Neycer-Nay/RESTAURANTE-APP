@extends('layouts.app')

@section('title', 'Categorias')
@section('page-title', 'Gestion de categorias')

@section('content')
    <x-ui.table-card title="Categorias" subtitle="Administra el catalogo de categorias para productos">
        <x-slot name="actions">
            <a class="btn btn-primary" href="{{ route('categorias.create') }}">Nueva categoria</a>
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
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->nombre_categoria }}</td>
                            <td>{{ $categoria->descripcion ?: '-' }}</td>
                            <td>
                                <span class="status-pill {{ $categoria->estado ? 'active' : 'inactive' }}">
                                    {{ $categoria->estado ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td>{{ $categoria->productos_count }}</td>
                            <td>
                                <div class="actions-inline">
                                    <a class="btn btn-light" href="{{ route('categorias.edit', $categoria) }}">Editar</a>
                                    <form method="POST" action="{{ route('categorias.destroy', $categoria) }}" onsubmit="return confirm('Deseas eliminar esta categoria?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay categorias registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $categorias->links() }}
        </div>
    </x-ui.table-card>
@endsection