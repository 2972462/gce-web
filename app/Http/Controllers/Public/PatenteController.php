<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PatenteComercialTramo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatenteController extends Controller
{
    public function index(): View
    {
        return view('public.patente.index');
    }

    public function calcular(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'monto' => ['required', 'numeric', 'min:0'],
        ]);

        $resultado = PatenteComercialTramo::calcular((float) $datos['monto']);

        return back()->withInput()->with([
            'resultado' => [
                'impuesto' => $resultado['impuesto'],
                'semestre1' => $resultado['semestre1'],
                'semestre2' => $resultado['semestre2'],
                'tramo' => [
                    'monto_desde' => (float) $resultado['tramo']->monto_desde,
                    'monto_hasta' => (float) $resultado['tramo']->monto_hasta,
                    'porcentaje' => (float) $resultado['tramo']->porcentaje,
                    'adicional' => (float) $resultado['tramo']->adicional,
                ],
            ],
        ]);
    }
}
