<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pagina;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaginaController extends Controller
{
    public function index(): View
    {
        $paginas = Pagina::orderBy('titulo')->get();

        return view('admin.paginas.index', compact('paginas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:paginas,slug'],
            'titulo' => ['required', 'string', 'max:255'],
        ]);

        $pagina = Pagina::create($datos);

        return redirect()->route('admin.paginas.show', $pagina);
    }

    public function show(Pagina $pagina): View
    {
        $pagina->load('secciones.bloques');

        return view('admin.paginas.show', compact('pagina'));
    }

    public function destroy(Pagina $pagina): RedirectResponse
    {
        $pagina->delete();

        return redirect()->route('admin.paginas.index');
    }
}
