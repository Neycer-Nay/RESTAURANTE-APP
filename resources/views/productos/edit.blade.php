@extends('layouts.app')

@section('title', 'Editar producto')
@section('page-title', 'Editar producto')

@section('content')
    <x-ui.form-card title="Editar producto" subtitle="Actualiza precios y configuracion de inventario base">
        <form method="POST" action="{{ route('productos.update', $producto) }}">
            @csrf
            @method('PUT')
            @include('productos.partials.form', [
                'producto' => $producto,
                'categorias' => $categorias,
                'marcas' => $marcas,
                'submitLabel' => 'Actualizar producto',
            ])
        </form>
    </x-ui.form-card>
@endsection