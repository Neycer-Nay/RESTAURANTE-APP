@extends('layouts.app')

@section('title', 'Editar categoria')
@section('page-title', 'Editar categoria')

@section('content')
    <x-ui.form-card title="Editar categoria" subtitle="Actualiza la informacion de la categoria">
        <form method="POST" action="{{ route('categorias.update', $categoria) }}">
            @csrf
            @method('PUT')
            @include('categorias.partials.form', ['categoria' => $categoria, 'submitLabel' => 'Actualizar categoria'])
        </form>
    </x-ui.form-card>
@endsection