<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BloqueRequest;
use App\Models\Bloque;
use App\Models\Seccion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BloqueController extends Controller
{
    public function create(Seccion $seccion, ?string $tipo = null): View
    {
        return view('admin.bloques.create', [
            'seccion' => $seccion,
            'tipo' => $tipo,
        ]);
    }

    public function store(BloqueRequest $request, Seccion $seccion): RedirectResponse
    {
        $datos = $request->validated();

        $seccion->bloques()->create([
            'tipo' => $datos['tipo'],
            'contenido' => $datos['contenido'] ?? [],
            'orden' => $seccion->bloques()->max('orden') + 1,
        ]);

        return redirect()->route('admin.paginas.show', $seccion->pagina_id);
    }

    public function edit(Bloque $bloque): View
    {
        return view('admin.bloques.edit', [
            'bloque' => $bloque,
        ]);
    }

    public function update(BloqueRequest $request, Bloque $bloque): RedirectResponse
    {
        $datos = $request->validated();

        $bloque->update([
            'contenido' => $datos['contenido'] ?? [],
        ]);

        return redirect()->route('admin.paginas.show', $bloque->seccion->pagina_id);
    }

    public function destroy(Bloque $bloque): RedirectResponse
    {
        $paginaId = $bloque->seccion->pagina_id;
        $bloque->delete();

        return redirect()->route('admin.paginas.show', $paginaId);
    }

    public function moveUp(Bloque $bloque): RedirectResponse
    {
        $bloque->moveUp();

        return redirect()->route('admin.paginas.show', $bloque->seccion->pagina_id);
    }

    public function moveDown(Bloque $bloque): RedirectResponse
    {
        $bloque->moveDown();

        return redirect()->route('admin.paginas.show', $bloque->seccion->pagina_id);
    }

    public function reorder(Request $request, Seccion $seccion): JsonResponse
    {
        $datos = $request->validate([
            'orden' => ['required', 'array'],
            'orden.*' => ['integer'],
        ]);

        $bloques = $seccion->bloques()->whereIn('id', $datos['orden'])->get()->keyBy('id');

        foreach ($datos['orden'] as $posicion => $id) {
            $bloques->get($id)?->update(['orden' => $posicion]);
        }

        return response()->json(['ok' => true]);
    }
}
