@extends('layouts.app')

@section('title', 'Nuevo rol')
@section('page-title', 'Crear rol')

@section('content')
    <x-ui.form-card title="Nuevo rol" subtitle="Define un nombre y descripcion opcional">
        <form method="POST" action="{{ route('roles.store') }}">
            @csrf
            @include('roles.partials.form', ['submitLabel' => 'Guardar rol'])
        </form>
    </x-ui.form-card>
@endsection
