<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProveedorController extends Controller
{
    public function index(): View
    {
        $proveedores = Proveedor::query()
            ->latest('id')
            ->paginate(10);

        return view('proveedores.index', compact('proveedores'));
    }

    public function create(): View
    {
        return view('proveedores.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'razon_social' => ['required', 'string', 'max:150'],
            'nombre_contacto' => ['nullable', 'string', 'max:100'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'direccion' => ['nullable', 'string'],
            'tipo_documento' => ['required', 'in:CI,NIT,Pasaporte,Otro'],
            'numero_documento' => ['nullable', 'string', 'max:50'],
            'activo' => ['required', 'boolean'],
        ]);

        Proveedor::create($data);

        return redirect()->route('proveedores.index')->with('swal_success', 'Proveedor creado correctamente.');
    }

    public function edit(Proveedor $proveedor): View
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor): RedirectResponse
    {
        $data = $request->validate([
            'razon_social' => ['required', 'string', 'max:150'],
            'nombre_contacto' => ['nullable', 'string', 'max:100'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'direccion' => ['nullable', 'string'],
            'tipo_documento' => ['required', 'in:CI,NIT,Pasaporte,Otro'],
            'numero_documento' => ['nullable', 'string', 'max:50'],
            'activo' => ['required', 'boolean'],
        ]);

        $proveedor->update($data);

        return redirect()->route('proveedores.index')->with('swal_success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedor): RedirectResponse
    {
        try {
            $proveedor->delete();

            return redirect()->route('proveedores.index')->with('swal_success', 'Proveedor eliminado correctamente.');
        } catch (QueryException) {
            return redirect()->route('proveedores.index')->with('error', 'No se pudo eliminar el proveedor porque tiene registros relacionados.');
        }
    }
}
