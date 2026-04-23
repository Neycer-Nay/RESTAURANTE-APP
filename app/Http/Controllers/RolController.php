<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RolController extends Controller
{
    public function index(): View
    {
        $roles = Rol::query()
            ->withCount('usuarios')
            ->latest('id')
            ->paginate(10);

        return view('roles.index', compact('roles'));
    }

    public function create(): View
    {
        return view('roles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre_rol' => ['required', 'string', 'max:50', 'unique:rols,nombre_rol'],
            'descripcion' => ['nullable', 'string'],
        ]);

        Rol::create($data);

        return redirect()->route('roles.index')->with('swal_success', 'Rol creado correctamente.');
    }

    public function edit(Rol $role): View
    {
        return view('roles.edit', ['role' => $role]);
    }

    public function update(Request $request, Rol $role): RedirectResponse
    {
        $data = $request->validate([
            'nombre_rol' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rols', 'nombre_rol')->ignore($role->id),
            ],
            'descripcion' => ['nullable', 'string'],
        ]);

        $role->update($data);

        return redirect()->route('roles.index')->with('swal_success', 'Rol actualizado correctamente.');
    }

    public function destroy( )
    {
        
    }
}
