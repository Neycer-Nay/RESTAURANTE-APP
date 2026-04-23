@extends('layouts.app')

@section('title', 'Editar proveedor')
@section('page-title', 'Editar proveedor')

@section('content')
    <x-ui.form-card title="Editar proveedor" subtitle="Actualiza la informacion del proveedor">
        <form method="POST" action="{{ route('proveedores.update', $proveedor) }}">
            @csrf
            @method('PUT')
            @include('proveedores.partials.form', ['proveedor' => $proveedor, 'submitLabel' => 'Actualizar proveedor'])
        </form>
    </x-ui.form-card>
@endsection