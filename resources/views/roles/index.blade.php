@extends('layouts.app')

@section('title', 'Roles')
@section('page-title', 'Gestion de roles')

@section('content')
    <x-ui.table-card title="Roles" subtitle="CRUD basico de acceso">
        <x-slot name="actions">
            <a class="btn btn-primary" href="{{ route('roles.create') }}">Nuevo rol</a>
        </x-slot>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Usuarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->nombre_rol }}</td>
                            <td>{{ $role->descripcion ?: '-' }}</td>
                            <td>{{ $role->usuarios_count }}</td>
                            <td>
                                <div class="actions-inline">
                                    <a class="btn btn-light" href="{{ route('roles.edit', $role) }}">Editar</a>

                                    <form method="POST" action="{{ route('roles.destroy', $role) }}" onsubmit="return confirm('Deseas eliminar este rol?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay roles registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $roles->links() }}
        </div>
    </x-ui.table-card>
@endsection
