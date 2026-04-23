<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(): View
    {
        $clientes = Cliente::query()
            ->latest('id')
            ->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    public function create(): View
    {
        return view('clientes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre_completo' => ['required', 'string', 'max:100'],
            'razon_social' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:100'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string'],
            'tipo_documento' => ['required', 'in:CI,NIT,Pasaporte,Otro'],
            'numero_documento' => ['nullable', 'string', 'max:50'],
            'activo' => ['required', 'boolean'],
        ]);

        Cliente::create($data);

        return redirect()->route('clientes.index')->with('swal_success', 'Cliente creado correctamente.');
    }

    public function edit(Cliente $cliente): View
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente): RedirectResponse
    {
        $data = $request->validate([
            'nombre_completo' => ['required', 'string', 'max:100'],
            'razon_social' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:100'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string'],
            'tipo_documento' => ['required', 'in:CI,NIT,Pasaporte,Otro'],
            'numero_documento' => ['nullable', 'string', 'max:50'],
            'activo' => ['required', 'boolean'],
        ]);

        $cliente->update($data);

        return redirect()->route('clientes.index')->with('swal_success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente): RedirectResponse
    {
        try {
            $cliente->delete();

            return redirect()->route('clientes.index')->with('swal_success', 'Cliente eliminado correctamente.');
        } catch (QueryException) {
            return redirect()->route('clientes.index')->with('error', 'No se pudo eliminar el cliente porque tiene registros relacionados.');
        }
    }
}
