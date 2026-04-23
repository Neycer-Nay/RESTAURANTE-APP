<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::query()
            ->withCount('productos')
            ->latest('id')
            ->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    public function create(): View
    {
        return view('categorias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre_categoria' => ['required', 'string', 'max:100', 'unique:categorias,nombre_categoria'],
            'descripcion' => ['nullable', 'string'],
            'estado' => ['required', 'boolean'],
        ]);

        Categoria::create($data);

        return redirect()->route('categorias.index')->with('swal_success', 'Categoria creada correctamente.');
    }

    public function edit(Categoria $categoria): View
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $data = $request->validate([
            'nombre_categoria' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categorias', 'nombre_categoria')->ignore($categoria->id),
            ],
            'descripcion' => ['nullable', 'string'],
            'estado' => ['required', 'boolean'],
        ]);

        $categoria->update($data);

        return redirect()->route('categorias.index')->with('swal_success', 'Categoria actualizada correctamente.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        try {
            $categoria->delete();

            return redirect()->route('categorias.index')->with('swal_success', 'Categoria eliminada correctamente.');
        } catch (QueryException) {
            return redirect()->route('categorias.index')->with('error', 'No se pudo eliminar la categoria porque tiene registros relacionados.');
        }
    }
}
