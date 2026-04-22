@extends('layouts.app')

@section('title', 'Editar usuario')
@section('page-title', 'Editar usuario')

@section('content')
    <x-ui.form-card title="Editar usuario" subtitle="Actualiza datos de acceso y perfil basico">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')
            @include('users.partials.form', [
                'user' => $user,
                'roles' => $roles,
                'isEdit' => true,
                'submitLabel' => 'Actualizar usuario',
            ])
        </form>
    </x-ui.form-card>
@endsection
