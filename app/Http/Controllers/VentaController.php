<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Inventario;
use App\Models\MetodoPago;
use App\Models\MovimientoCaja;
use App\Models\MovimientoInventario;
use App\Models\PagoVenta;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class VentaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Venta::query()
            ->with(['cliente', 'usuario', 'caja'])
            ->latest('fecha_venta');

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_venta', '>=', $request->input('fecha_desde'));
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_venta', '<=', $request->input('fecha_hasta'));
        }

        if ($request->filled('id_usuario')) {
            $query->where('id_usuario', $request->input('id_usuario'));
        }

        if ($request->filled('id_cliente')) {
            $query->where('id_cliente', $request->input('id_cliente'));
        }

        $ventas = $query->paginate(15)->withQueryString();
        $usuarios = User::orderBy('name')->get();
        $clientes = Cliente::where('activo', true)->orderBy('nombre_completo')->get();

        return view('ventas.index', compact('ventas', 'usuarios', 'clientes'));
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

        $clientes = Cliente::where('activo', true)->orderBy('nombre_completo')->get();
        $metodosPago = MetodoPago::orderBy('nombre_metodo')->get();

        return view('ventas.create', compact('cajaAbierta', 'productos', 'clientes', 'metodosPago'));
    }

    public function store(Request $request): RedirectResponse
    {
        $cajaAbierta = Caja::where('id_usuario', auth()->id())
            ->where('estado_caja', 'abierta')
            ->first();

        if (! $cajaAbierta) {
            return redirect()->route('ventas.create')
                ->with('swal_success', 'No tienes una caja abierta. Abre una caja antes de realizar una venta.');
        }

        $validated = $request->validate([
            'id_cliente' => ['nullable', 'exists:clientes,id'],
            'productos' => ['required', 'array', 'min:1'],
            'productos.*.id_producto' => ['required', 'exists:productos,id'],
            'productos.*.cantidad' => ['required', 'integer', 'min:1'],
            'productos.*.precio_unitario' => ['required', 'numeric', 'min:0'],
            'pagos' => ['required', 'array', 'min:1'],
            'pagos.*.id_metodo_pago' => ['required', 'exists:metodo_pagos,id'],
            'pagos.*.monto' => ['required', 'numeric', 'min:0'],
            'pagos.*.referencia' => ['nullable', 'string', 'max:100'],
        ]);

        // Calcular totales y validar stock
        $subtotal = 0;
        foreach ($validated['productos'] as $item) {
            $producto = Producto::with('inventario')->find($item['id_producto']);
            $cantidad = (int) $item['cantidad'];
            $precio = (float) $item['precio_unitario'];

            if (! $producto || ! $producto->inventario) {
                return redirect()->back()->withInput()
                    ->with('swal_success', "El producto no tiene inventario registrado.");
            }

            if ($producto->inventario->cantidad_actual < $cantidad) {
                return redirect()->back()->withInput()
                    ->with('swal_success', "Stock insuficiente para {$producto->nombre_producto}. Disponible: {$producto->inventario->cantidad_actual}.");
            }

            $subtotal += $cantidad * $precio;
        }

        $totalPagos = collect($validated['pagos'])->sum('monto');
        if (abs($totalPagos - $subtotal) > 0.01) {
            return redirect()->back()->withInput()
                ->with('swal_success', "El total de pagos ({$totalPagos}) no coincide con el total de la venta ({$subtotal}).");
        }

        DB::beginTransaction();

        try {
            $venta = Venta::create([
                'id_caja' => $cajaAbierta->id,
                'id_usuario' => auth()->id(),
                'id_cliente' => $validated['id_cliente'] ?? null,
                'fecha_venta' => now(),
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'estado' => true,
            ]);

            foreach ($validated['productos'] as $item) {
                $cantidad = (int) $item['cantidad'];
                $precio = (float) $item['precio_unitario'];
                $subtotalLinea = $cantidad * $precio;

                DetalleVenta::create([
                    'id_venta' => $venta->id,
                    'id_producto' => $item['id_producto'],
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                    'subtotal' => $subtotalLinea,
                ]);

                $inventario = Inventario::where('id_producto', $item['id_producto'])->first();
                $inventario->decrement('cantidad_actual', $cantidad);
                $inventario->update(['ultima_actualizacion' => now()]);

                MovimientoInventario::create([
                    'id_producto' => $item['id_producto'],
                    'tipo_movimiento' => 'venta',
                    'cantidad' => $cantidad,
                    'referencia_id' => $venta->id,
                    'concepto' => 'Venta #' . $venta->id,
                    'fecha_movimiento' => now(),
                ]);
            }

            foreach ($validated['pagos'] as $pago) {
                PagoVenta::create([
                    'id_venta' => $venta->id,
                    'id_metodo_pago' => $pago['id_metodo_pago'],
                    'monto' => $pago['monto'],
                    'referencia' => $pago['referencia'] ?? null,
                ]);
            }

            MovimientoCaja::create([
                'id_caja' => $cajaAbierta->id,
                'id_usuario' => auth()->id(),
                'tipo_movimiento' => 'ingreso',
                'monto' => $subtotal,
                'fecha_movimiento' => now(),
                'concepto' => 'Venta #' . $venta->id,
                'detalle' => 'Ingreso por venta',
            ]);

            DB::commit();

            return redirect()->route('ventas.show', $venta)->with('swal_success', 'Venta registrada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->withInput()
                ->with('swal_success', 'Error al registrar la venta: ' . $e->getMessage());
        }
    }

    public function show(Venta $venta): View
    {
        $venta->load(['cliente', 'usuario', 'caja', 'detallesVenta.producto', 'pagosVenta.metodoPago']);

        return view('ventas.show', compact('venta'));
    }

    public function anular(Venta $venta): RedirectResponse
    {
        if (! $venta->estado) {
            return redirect()->route('ventas.show', $venta)
                ->with('swal_success', 'La venta ya está anulada.');
        }

        $caja = Caja::find($venta->id_caja);
        if (! $caja) {
            return redirect()->route('ventas.show', $venta)
                ->with('swal_success', 'No se encontró la caja asociada a la venta.');
        }

        DB::beginTransaction();

        try {
            $venta->update(['estado' => false]);

            foreach ($venta->detallesVenta as $detalle) {
                $inventario = Inventario::where('id_producto', $detalle->id_producto)->first();
                if ($inventario) {
                    $inventario->increment('cantidad_actual', $detalle->cantidad);
                    $inventario->update(['ultima_actualizacion' => now()]);
                }

                MovimientoInventario::create([
                    'id_producto' => $detalle->id_producto,
                    'tipo_movimiento' => 'anulacion_venta',
                    'cantidad' => $detalle->cantidad,
                    'referencia_id' => $venta->id,
                    'concepto' => 'Anulación Venta #' . $venta->id,
                    'fecha_movimiento' => now(),
                ]);
            }

            MovimientoCaja::create([
                'id_caja' => $caja->id,
                'id_usuario' => auth()->id(),
                'tipo_movimiento' => 'salida',
                'monto' => $venta->total,
                'fecha_movimiento' => now(),
                'concepto' => 'Anulación Venta #' . $venta->id,
                'detalle' => 'Reversión de ingreso por anulación',
            ]);

            DB::commit();

            return redirect()->route('ventas.show', $venta)->with('swal_success', 'Venta anulada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->route('ventas.show', $venta)
                ->with('swal_success', 'Error al anular la venta: ' . $e->getMessage());
        }
    }
}

