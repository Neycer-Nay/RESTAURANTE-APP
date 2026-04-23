@extends('layouts.app')

@section('title', 'Editar metodo de pago')
@section('page-title', 'Editar metodo de pago')

@section('content')
    <x-ui.form-card title="Editar metodo de pago" subtitle="Actualiza el nombre del metodo de pago">
        <form method="POST" action="{{ route('metodos-pago.update', $metodoPago) }}">
            @csrf
            @method('PUT')
            @include('metodo_pagos.partials.form', ['metodoPago' => $metodoPago, 'submitLabel' => 'Actualizar metodo'])
        </form>
    </x-ui.form-card>
@endsection