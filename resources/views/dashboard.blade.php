@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="stats-grid">
        <article class="stat-item">
            <p class="stat-label">Usuarios registrados</p>
            <p class="stat-value">{{ $totalUsuarios }}</p>
        </article>

        <article class="stat-item">
            <p class="stat-label">Usuarios activos</p>
            <p class="stat-value">{{ $usuariosActivos }}</p>
        </article>

        {{--  <article class="stat-item">
            <p class="stat-label">Roles configurados</p>
            <p class="stat-value">{{ $totalRoles }}</p>
        </article>--}}
    </div>

    <x-ui.table-card title="Accesos rapidos" subtitle="Gestion base de seguridad">
        <x-slot name="actions">
            <a class="btn btn-primary" href="{{ route('users.create') }}">Nuevo usuario</a>
        </x-slot>

        <div class="actions-inline">
            <a class="btn btn-light" href="{{ route('roles.index') }}">Ir a roles</a>
            <a class="btn btn-light" href="{{ route('users.index') }}">Ir a usuarios</a>
        </div>
    </x-ui.table-card>
@endsection
