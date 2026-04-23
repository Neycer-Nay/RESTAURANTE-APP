@extends('layouts.app')

@section('title', 'Nueva categoria')
@section('page-title', 'Crear categoria')

@section('content')
    <x-ui.form-card title="Nueva categoria" subtitle="Define grupos para organizar productos">
        <form method="POST" action="{{ route('categorias.store') }}">
            @csrf
            @include('categorias.partials.form', ['submitLabel' => 'Guardar categoria'])
        </form>
    </x-ui.form-card>
@endsection