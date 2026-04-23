@extends('layouts.app')

@section('title', 'Nuevo producto')
@section('page-title', 'Crear producto')

@section('content')
    <x-ui.form-card title="Nuevo producto" subtitle="Alta de producto con inicializacion de inventario">
        <form method="POST" action="{{ route('productos.store') }}">
            @csrf
            @include('productos.partials.form', [
                'categorias' => $categorias,
                'marcas' => $marcas,
                'submitLabel' => 'Guardar producto',
            ])
        </form>
    </x-ui.form-card>
@endsection