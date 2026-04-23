@extends('layouts.app')

@section('title', 'Nueva marca')
@section('page-title', 'Crear marca')

@section('content')
    <x-ui.form-card title="Nueva marca" subtitle="Registra una marca para clasificar productos">
        <form method="POST" action="{{ route('marcas.store') }}">
            @csrf
            @include('marcas.partials.form', ['submitLabel' => 'Guardar marca'])
        </form>
    </x-ui.form-card>
@endsection