@extends('layouts.app')

@section('title', 'Nuevo cliente')
@section('page-title', 'Crear cliente')

@section('content')
    <x-ui.form-card title="Nuevo cliente" subtitle="Registra un cliente para ventas y facturacion">
        <form method="POST" action="{{ route('clientes.store') }}">
            @csrf
            @include('clientes.partials.form', ['submitLabel' => 'Guardar cliente'])
        </form>
    </x-ui.form-card>
@endsection