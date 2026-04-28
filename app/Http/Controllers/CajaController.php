<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CajaController extends Controller
{
    public function index(): View
    {
        $cajas = Caja::query()
            ->with('usuario')
            ->latest('fecha_apertura')
            ->paginate(15);

        return view('cajas.index', compact('cajas'));
    }

    public function create(): View
    {
        $cajaAbierta = Caja::where('id_usuario', auth()->id())
            ->where('estado_caja', 'abierta')
            ->first();

        return view('cajas.create', compact('cajaAbierta'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'monto_apertura' => ['required', 'numeric', 'min:0'],
        ]);

        $existeAbierta = Caja::where('id_usuario', auth()->id())
            ->where('estado_caja', 'abierta')
            ->exists();

        if ($existeAbierta) {
            return redirect()->route('cajas.index')
                ->with('swal_success', 'Ya tienes una caja abierta. Ciérrala antes de abrir una nueva.');
        }

        Caja::create([
            'id_usuario' => auth()->id(),
            'fecha_apertura' => now(),
            'fecha_cierre' => null,
            'monto_apertura' => $data['monto_apertura'],
            'monto_cierre' => null,
            'estado_caja' => 'abierta',
        ]);

        return redirect()->route('cajas.index')->with('swal_success', 'Caja abierta correctamente.');
    }

    public function show(Caja $caja): View
    {
        $caja->load(['usuario', 'movimientos.usuario', 'ventas.cliente', 'ventas.usuario']);

        return view('cajas.show', compact('caja'));
    }

    public function close(Request $request, Caja $caja): RedirectResponse
    {
        if ($caja->estado_caja === 'cerrada') {
            return redirect()->route('cajas.show', $caja)
                ->with('swal_success', 'La caja ya está cerrada.');
        }

        $data = $request->validate([
            'monto_cierre' => ['required', 'numeric', 'min:0'],
        ]);

        $caja->update([
            'fecha_cierre' => now(),
            'monto_cierre' => $data['monto_cierre'],
            'estado_caja' => 'cerrada',
        ]);

        return redirect()->route('cajas.index')->with('swal_success', 'Caja cerrada correctamente.');
    }
}

