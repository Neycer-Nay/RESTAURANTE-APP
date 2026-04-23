<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MarcaController extends Controller
{
    public function index(): View
    {
        $marcas = Marca::query()
            ->withCount('productos')
            ->latest('id')
            ->paginate(10);

        return view('marcas.index', compact('marcas'));
    }

    public function create(): View
    {
        return view('marcas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre_marca' => ['required', 'string', 'max:100', 'unique:marcas,nombre_marca'],
            'descripcion' => ['nullable', 'string'],
            'estado' => ['required', 'boolean'],
        ]);

        Marca::create($data);

        return redirect()->route('marcas.index')->with('swal_success', 'Marca creada correctamente.');
    }

    public function edit(Marca $marca): View
    {
        return view('marcas.edit', compact('marca'));
    }

    public function update(Request $request, Marca $marca): RedirectResponse
    {
        $data = $request->validate([
            'nombre_marca' => [
                'required',
                'string',
                'max:100',
                Rule::unique('marcas', 'nombre_marca')->ignore($marca->id),
            ],
            'descripcion' => ['nullable', 'string'],
            'estado' => ['required', 'boolean'],
        ]);

        $marca->update($data);

        return redirect()->route('marcas.index')->with('swal_success', 'Marca actualizada correctamente.');
    }

    public function destroy(Marca $marca): RedirectResponse
    {
        try {
            $marca->delete();

            return redirect()->route('marcas.index')->with('swal_success', 'Marca eliminada correctamente.');
        } catch (QueryException) {
            return redirect()->route('marcas.index')->with('error', 'No se pudo eliminar la marca porque tiene registros relacionados.');
        }
    }
}
