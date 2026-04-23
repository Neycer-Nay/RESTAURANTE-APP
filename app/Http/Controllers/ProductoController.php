<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Inventario;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function index(): View
    {
        $productos = Producto::query()
            ->with(['categoria', 'marca', 'inventario'])
            ->latest('id')
            ->paginate(10);

        return view('productos.index', compact('productos'));
    }

    public function create(): View
    {
        $categorias = Categoria::query()
            ->orderBy('nombre_categoria')
            ->get();

        $marcas = Marca::query()
            ->orderBy('nombre_marca')
            ->get();

        return view('productos.create', compact('categorias', 'marcas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre_producto' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'precio_compra' => ['required', 'numeric', 'min:0'],
            'precio_venta' => ['required', 'numeric', 'min:0', 'gte:precio_compra'],
            'tipo_producto' => ['required', 'in:almacenable,elaborado'],
            'id_categoria' => ['nullable', 'exists:categorias,id'],
            'id_marca' => ['nullable', 'exists:marcas,id'],
            'activo' => ['required', 'boolean'],
            'cantidad_minima' => ['required', 'integer', 'min:0'],
            'cantidad_maxima' => ['required', 'integer', 'gte:cantidad_minima'],
        ]);

        DB::transaction(function () use ($data): void {
            $producto = Producto::create([
                'nombre_producto' => $data['nombre_producto'],
                'descripcion' => $data['descripcion'] ?? null,
                'precio_venta' => $data['precio_venta'],
                'margen_ganancia' => $data['precio_venta'] - $data['precio_compra'],
                'precio_compra' => $data['precio_compra'],
                'tipo_producto' => $data['tipo_producto'],
                'id_categoria' => $data['id_categoria'] ?? null,
                'id_marca' => $data['id_marca'] ?? null,
                'fecha_creacion' => now(),
                'activo' => $data['activo'],
            ]);

            Inventario::create([
                'id_producto' => $producto->id,
                'cantidad_actual' => 0,
                'cantidad_minima' => $data['cantidad_minima'],
                'cantidad_maxima' => $data['cantidad_maxima'],
                'ultima_actualizacion' => now(),
            ]);
        });

        return redirect()->route('productos.index')->with('swal_success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto): View
    {
        $producto->load('inventario');

        $categorias = Categoria::query()
            ->orderBy('nombre_categoria')
            ->get();

        $marcas = Marca::query()
            ->orderBy('nombre_marca')
            ->get();

        return view('productos.edit', compact('producto', 'categorias', 'marcas'));
    }

    public function update(Request $request, Producto $producto): RedirectResponse
    {
        $data = $request->validate([
            'nombre_producto' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'precio_compra' => ['required', 'numeric', 'min:0'],
            'precio_venta' => ['required', 'numeric', 'min:0', 'gte:precio_compra'],
            'tipo_producto' => ['required', 'in:almacenable,elaborado'],
            'id_categoria' => ['nullable', 'exists:categorias,id'],
            'id_marca' => ['nullable', 'exists:marcas,id'],
            'activo' => ['required', 'boolean'],
            'cantidad_minima' => ['required', 'integer', 'min:0'],
            'cantidad_maxima' => ['required', 'integer', 'gte:cantidad_minima'],
        ]);

        DB::transaction(function () use ($data, $producto): void {
            $producto->update([
                'nombre_producto' => $data['nombre_producto'],
                'descripcion' => $data['descripcion'] ?? null,
                'precio_venta' => $data['precio_venta'],
                'margen_ganancia' => $data['precio_venta'] - $data['precio_compra'],
                'precio_compra' => $data['precio_compra'],
                'tipo_producto' => $data['tipo_producto'],
                'id_categoria' => $data['id_categoria'] ?? null,
                'id_marca' => $data['id_marca'] ?? null,
                'activo' => $data['activo'],
            ]);

            $inventarioActual = $producto->inventario;

            Inventario::updateOrCreate(
                ['id_producto' => $producto->id],
                [
                    'cantidad_actual' => $inventarioActual?->cantidad_actual ?? 0,
                    'cantidad_minima' => $data['cantidad_minima'],
                    'cantidad_maxima' => $data['cantidad_maxima'],
                    'ultima_actualizacion' => now(),
                ]
            );
        });

        return redirect()->route('productos.index')->with('swal_success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        try {
            $producto->delete();

            return redirect()->route('productos.index')->with('swal_success', 'Producto eliminado correctamente.');
        } catch (QueryException) {
            return redirect()->route('productos.index')->with('error', 'No se pudo eliminar el producto porque tiene registros relacionados.');
        }
    }
}
