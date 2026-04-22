@extends('layouts.app')

@section('title', 'Nuevo usuario')
@section('page-title', 'Crear usuario')

@section('content')
    <x-ui.form-card title="Nuevo usuario" subtitle="Crea cuentas para acceso al sistema">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            @include('users.partials.form', ['roles' => $roles, 'submitLabel' => 'Guardar usuario'])
        </form>
    </x-ui.form-card>
@endsection
