@extends('layouts.app')

@section('title', 'Editar cliente')
@section('page-title', 'Editar cliente')

@section('content')
    <x-ui.form-card title="Editar cliente" subtitle="Actualiza la informacion del cliente seleccionado">
        <form method="POST" action="{{ route('clientes.update', $cliente) }}">
            @csrf
            @method('PUT')
            @include('clientes.partials.form', ['cliente' => $cliente, 'submitLabel' => 'Actualizar cliente'])
        </form>
    </x-ui.form-card>
@endsection