@extends('layouts.app')

@section('title', 'Nuevo proveedor')
@section('page-title', 'Crear proveedor')

@section('content')
    <x-ui.form-card title="Nuevo proveedor" subtitle="Registra proveedores para abastecimiento">
        <form method="POST" action="{{ route('proveedores.store') }}">
            @csrf
            @include('proveedores.partials.form', ['submitLabel' => 'Guardar proveedor'])
        </form>
    </x-ui.form-card>
@endsection