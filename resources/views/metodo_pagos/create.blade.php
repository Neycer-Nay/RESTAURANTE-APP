@extends('layouts.app')

@section('title', 'Nuevo metodo de pago')
@section('page-title', 'Crear metodo de pago')

@section('content')
    <x-ui.form-card title="Nuevo metodo de pago" subtitle="Registra medios de pago aceptados por el sistema">
        <form method="POST" action="{{ route('metodos-pago.store') }}">
            @csrf
            @include('metodo_pagos.partials.form', ['submitLabel' => 'Guardar metodo'])
        </form>
    </x-ui.form-card>
@endsection