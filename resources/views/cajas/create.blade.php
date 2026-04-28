@extends('layouts.app')

@section('title', 'Abrir caja')
@section('page-title', 'Abrir caja')

@section('content')
    <x-ui.form-card title="Apertura de caja" subtitle="Ingrese el monto inicial">
        @if ($cajaAbierta)
            <div class="alert alert-error">
                Ya tienes una caja abierta (ID: {{ $cajaAbierta->id }}).
                <a href="{{ route('cajas.show', $cajaAbierta) }}">Ver caja</a>.
            </div>
        @else
            <form method="POST" action="{{ route('cajas.store') }}">
                @csrf

                <div class="form-grid">
                    <div class="field">
                        <label>Monto de apertura</label>
                        <input type="number" step="0.01" min="0" name="monto_apertura" class="input"
                            value="{{ old('monto_apertura', 0) }}" required>
                        @error('monto_apertura')
                            <p style="color:#b91c1c;font-size:13px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('cajas.index') }}" class="btn btn-light">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Abrir caja</button>
                </div>
            </form>
        @endif
    </x-ui.form-card>
@endsection

