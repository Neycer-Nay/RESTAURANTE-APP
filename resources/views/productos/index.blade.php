@extends('layouts.app')

@section('title', 'Productos')
@section('page-title', 'Gestion de productos')

@section('content')
    <x-ui.table-card title="Productos" subtitle="Catalogo de productos y configuracion de inventario base">
        <x-slot name="actions">
            <a class="btn btn-primary" href="{{ route('productos.create') }}">Nuevo producto</a>
        </x-slot>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categoria / Marca</th>
                        <th>Tipo</th>
                        <th>Precios</th>
                        <th>Inventario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                        @php
                            $inventario = $producto->inventario;
                        @endphp
                        <tr>
                            <td>
                                <div>{{ $producto->nombre_producto }}</div>
                                <div>{{ $producto->descripcion ?: '-' }}</div>
                            </td>
                            <td>
                                <div>Cat: {{ optional($producto->categoria)->nombre_categoria ?: 'Sin categoria' }}</div>
                                <div>Marca: {{ optional($producto->marca)->nombre_marca ?: 'Sin marca' }}</div>
                            </td>
                            <td>{{ ucfirst($producto->tipo_producto) }}</td>
                            <td>
                                <div>Compra: {{ number_format((float) $producto->precio_compra, 2) }}</div>
                                <div>Venta: {{ number_format((float) $producto->precio_venta, 2) }}</div>
                                <div>Margen: {{ number_format((float) $producto->margen_ganancia, 2) }}</div>
                            </td>
                            <td>
                                <div>Actual: {{ $inventario?->cantidad_actual ?? 0 }}</div>
                                <div>Min: {{ $inventario?->cantidad_minima ?? 0 }}</div>
                                <div>Max: {{ $inventario?->cantidad_maxima ?? 0 }}</div>
                            </td>
                            <td>
                                <span class="status-pill {{ $producto->activo ? 'active' : 'inactive' }}">
                                    {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-inline">
                                    <a class="btn btn-light" href="{{ route('productos.edit', $producto) }}">Editar</a>
                                    <form method="POST" action="{{ route('productos.destroy', $producto) }}" onsubmit="return confirm('Deseas eliminar este producto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $productos->links() }}
        </div>
    </x-ui.table-card>
@endsection
