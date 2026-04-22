@extends('layouts.app')

@section('title', 'Editar rol')
@section('page-title', 'Editar rol')

@section('content')
    <x-ui.form-card title="Editar rol" subtitle="Actualiza la configuracion del rol seleccionado">
        <form method="POST" action="{{ route('roles.update', $role) }}">
            @csrf
            @method('PUT')
            @include('roles.partials.form', ['role' => $role, 'submitLabel' => 'Actualizar rol'])
        </form>
    </x-ui.form-card>
@endsection
