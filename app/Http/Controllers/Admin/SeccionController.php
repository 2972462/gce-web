<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pagina;
use App\Models\Seccion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SeccionController extends Controller
{
    public function store(Request $request, Pagina $pagina): RedirectResponse
    {
        $datos = $request->validate([
            'clave' => ['required', 'string', 'max:255', 'alpha_dash'],
            'titulo' => ['required', 'string', 'max:255'],
        ]);

        $pagina->secciones()->create([
            ...$datos,
            'orden' => $pagina->secciones()->max('orden') + 1,
        ]);

        return redirect()->route('admin.paginas.show', $pagina);
    }

    public function update(Request $request, Seccion $seccion): RedirectResponse
    {
        $datos = $request->validate([
            'clave' => ['required', 'string', 'max:255', 'alpha_dash'],
            'titulo' => ['required', 'string', 'max:255'],
        ]);

        $seccion->update($datos);

        return redirect()->route('admin.paginas.show', $seccion->pagina_id);
    }

    public function destroy(Seccion $seccion): RedirectResponse
    {
        $paginaId = $seccion->pagina_id;
        $seccion->delete();

        return redirect()->route('admin.paginas.show', $paginaId);
    }

    public function moveUp(Seccion $seccion): RedirectResponse
    {
        $seccion->moveUp();

        return redirect()->route('admin.paginas.show', $seccion->pagina_id);
    }

    public function moveDown(Seccion $seccion): RedirectResponse
    {
        $seccion->moveDown();

        return redirect()->route('admin.paginas.show', $seccion->pagina_id);
    }

    public function reorder(Request $request, Pagina $pagina): JsonResponse
    {
        $datos = $request->validate([
            'orden' => ['required', 'array'],
            'orden.*' => ['integer'],
        ]);

        $secciones = $pagina->secciones()->whereIn('id', $datos['orden'])->get()->keyBy('id');

        foreach ($datos['orden'] as $posicion => $id) {
            $secciones->get($id)?->update(['orden' => $posicion]);
        }

        return response()->json(['ok' => true]);
    }
}
