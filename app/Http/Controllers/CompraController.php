<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Inventario;
use App\Models\MetodoPago;
use App\Models\MovimientoCaja;
use App\Models\MovimientoInventario;
use App\Models\PagoCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CompraController extends Controller
{
    public function index(Request $request): View
    {
        $query = Compra::query()
            ->with(['proveedor', 'usuario', 'caja'])
            ->latest('fecha_compra');

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_compra', '>=', $request->input('fecha_desde'));
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_compra', '<=', $request->input('fecha_hasta'));
        }

        if ($request->filled('id_proveedor')) {
            $query->where('id_proveedor', $request->input('id_proveedor'));
        }

        $compras = $query->paginate(15)->withQueryString();
        $proveedores = Proveedor::where('activo', true)->orderBy('razon_social')->get();

        return view('compras.index', compact('compras', 'proveedores'));
    }

    public function create(): View
    {
        $cajaAbierta = Caja::where('id_usuario', auth()->id())
            ->where('estado_caja', 'abierta')
            ->first();

        $productos = Producto::where('activo', true)
            ->with('inventario')
            ->orderBy('nombre_producto')
            ->get();

        $proveedores = Proveedor::where('activo', true)->orderBy('razon_social')->get();
        $metodosPago = MetodoPago::orderBy('nombre_metodo')->get();

        return view('compras.create', compact('cajaAbierta', 'productos', 'proveedores', 'metodosPago'));
    }

    public function store(Request $request): RedirectResponse
    {
        $cajaAbierta = Caja::where('id_usuario', auth()->id())
            ->where('estado_caja', 'abierta')
            ->first();

        if (! $cajaAbierta) {
            return redirect()->route('compras.create')
                ->with('swal_success', 'No tienes una caja abierta. Abre una caja antes de realizar una compra.');
        }

        $validated = $request->validate([
            'id_proveedor' => ['nullable', 'exists:proveedors,id'],
            'productos' => ['required', 'array', 'min:1'],
            'productos.*.id_producto' => ['required', 'exists:productos,id'],
            'productos.*.cantidad' => ['required', 'integer', 'min:1'],
            'productos.*.precio_unitario' => ['required', 'numeric', 'min:0'],
            'pagos' => ['nullable', 'array'],
            'pagos.*.id_metodo_pago' => ['required', 'exists:metodo_pagos,id'],
            'pagos.*.monto' => ['required', 'numeric', 'min:0'],
            'pagos.*.referencia' => ['nullable', 'string', 'max:100'],
        ]);

        // Calcular totales
        $subtotal = 0;
        foreach ($validated['productos'] as $item) {
            $cantidad = (int) $item['cantidad'];
            $precio = (float) $item['precio_unitario'];
            $subtotal += $cantidad * $precio;
        }

        // Validar pagos si se proporcionan
        $hayPagos = !empty($validated['pagos']);
        if ($hayPagos) {
            $totalPagos = collect($validated['pagos'])->sum('monto');
            if (abs($totalPagos - $subtotal) > 0.01) {
                return redirect()->back()->withInput()
                    ->with('swal_success', "El total de pagos ({$totalPagos}) no coincide con el total de la compra ({$subtotal}).");
            }
        }

        DB::beginTransaction();

        try {
            $compra = Compra::create([
                'id_caja' => $cajaAbierta->id,
                'id_usuario' => auth()->id(),
                'id_proveedor' => $validated['id_proveedor'] ?? null,
                'fecha_compra' => now(),
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'estado' => true,
            ]);

            foreach ($validated['productos'] as $item) {
                $cantidad = (int) $item['cantidad'];
                $precio = (float) $item['precio_unitario'];
                $subtotalLinea = $cantidad * $precio;

                DetalleCompra::create([
                    'id_compra' => $compra->id,
                    'id_producto' => $item['id_producto'],
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                    'subtotal' => $subtotalLinea,
                ]);

                $inventario = Inventario::where('id_producto', $item['id_producto'])->first();
                if ($inventario) {
                    $inventario->increment('cantidad_actual', $cantidad);
                    $inventario->update(['ultima_actualizacion' => now()]);
                } else {
                    Inventario::create([
                        'id_producto' => $item['id_producto'],
                        'cantidad_actual' => $cantidad,
                        'cantidad_minima' => 0,
                        'cantidad_maxima' => 0,
                        'ultima_actualizacion' => now(),
                    ]);
                }

                MovimientoInventario::create([
                    'id_producto' => $item['id_producto'],
                    'tipo_movimiento' => 'compra',
                    'cantidad' => $cantidad,
                    'referencia_id' => $compra->id,
                    'concepto' => 'Compra #' . $compra->id,
                    'fecha_movimiento' => now(),
                ]);
            }

            if ($hayPagos) {
                foreach ($validated['pagos'] as $pago) {
                    PagoCompra::create([
                        'id_compra' => $compra->id,
                        'id_metodo_pago' => $pago['id_metodo_pago'],
                        'monto' => $pago['monto'],
                        'referencia' => $pago['referencia'] ?? null,
                    ]);
                }

                MovimientoCaja::create([
                    'id_caja' => $cajaAbierta->id,
                    'id_usuario' => auth()->id(),
                    'tipo_movimiento' => 'salida',
                    'monto' => $subtotal,
                    'fecha_movimiento' => now(),
                    'concepto' => 'Compra #' . $compra->id,
                    'detalle' => 'Salida por compra a proveedor',
                ]);
            }

            DB::commit();

            return redirect()->route('compras.show', $compra)->with('swal_success', 'Compra registrada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->withInput()
                ->with('swal_success', 'Error al registrar la compra: ' . $e->getMessage());
        }
    }

    public function show(Compra $compra): View
    {
        $compra->load(['proveedor', 'usuario', 'caja', 'detalles.producto', 'pagosCompra.metodoPago']);

        return view('compras.show', compact('compra'));
    }
}

