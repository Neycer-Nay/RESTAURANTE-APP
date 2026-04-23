@extends('layouts.app')

@section('title', 'Usuarios')
@section('page-title', 'Gestion de usuarios')

@section('content')
    <x-ui.table-card title="Usuarios" subtitle="Administracion basica de acceso al sistema">
        <x-slot name="actions">
            <a class="btn btn-primary" href="{{ route('users.create') }}">Nuevo usuario</a>
        </x-slot>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ optional($user->rol)->nombre_rol ?: 'Sin rol' }}</td>
                            <td>
                                <span class="status-pill {{ $user->activo ? 'active' : 'inactive' }}">
                                    {{ $user->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-inline">
                                    <a class="btn btn-light" href="{{ route('users.edit', $user) }}">Editar</a>

                                    
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $users->links() }}
        </div>
    </x-ui.table-card>
@endsection


