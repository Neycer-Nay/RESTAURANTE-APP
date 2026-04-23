@extends('layouts.app')

@section('title', 'Editar marca')
@section('page-title', 'Editar marca')

@section('content')
    <x-ui.form-card title="Editar marca" subtitle="Actualiza la informacion de la marca">
        <form method="POST" action="{{ route('marcas.update', $marca) }}">
            @csrf
            @method('PUT')
            @include('marcas.partials.form', ['marca' => $marca, 'submitLabel' => 'Actualizar marca'])
        </form>
    </x-ui.form-card>
@endsection