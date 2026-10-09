<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PatenteComercialTramo;
use Illuminate\View\View;

class PatenteController extends Controller
{
    public function index(): View
    {
        $tramos = PatenteComercialTramo::orderBy('orden')->get();

        // Enteros/float planos (no el modelo completo) para que el JSON
        // embebido no arrastre el problema de precision del "999999999999999".
        $tramosParaJs = $tramos->map(fn (PatenteComercialTramo $t) => [
            'desde' => (int) $t->monto_desde,
            'hasta' => (int) $t->monto_hasta,
            'porcentaje' => (float) $t->porcentaje,
            'adicional' => (int) $t->adicional,
        ]);

        return view('public.patente.index', compact('tramos', 'tramosParaJs'));
    }
}
