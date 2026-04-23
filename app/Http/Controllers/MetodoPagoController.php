<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MetodoPagoController extends Controller
{
    public function index(): View
    {
        $metodosPago = MetodoPago::query()
            ->withCount(['pagosVenta', 'pagosCompra'])
            ->latest('id')
            ->paginate(10);

        return view('metodo_pagos.index', compact('metodosPago'));
    }

    public function create(): View
    {
        return view('metodo_pagos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre_metodo' => ['required', 'string', 'max:50', 'unique:metodo_pagos,nombre_metodo'],
        ]);

        MetodoPago::create($data);

        return redirect()->route('metodos-pago.index')->with('swal_success', 'Metodo de pago creado correctamente.');
    }

    public function edit(MetodoPago $metodoPago): View
    {
        return view('metodo_pagos.edit', compact('metodoPago'));
    }

    public function update(Request $request, MetodoPago $metodoPago): RedirectResponse
    {
        $data = $request->validate([
            'nombre_metodo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('metodo_pagos', 'nombre_metodo')->ignore($metodoPago->id),
            ],
        ]);

        $metodoPago->update($data);

        return redirect()->route('metodos-pago.index')->with('swal_success', 'Metodo de pago actualizado correctamente.');
    }

    public function destroy(MetodoPago $metodoPago): RedirectResponse
    {
        try {
            $metodoPago->delete();

            return redirect()->route('metodos-pago.index')->with('swal_success', 'Metodo de pago eliminado correctamente.');
        } catch (QueryException) {
            return redirect()->route('metodos-pago.index')->with('error', 'No se pudo eliminar el metodo de pago porque tiene registros relacionados.');
        }
    }
}
