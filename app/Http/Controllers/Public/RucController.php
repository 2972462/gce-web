<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ConsultaRuc;
use App\Rules\Recaptcha;
use App\Services\RucBuscador;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RucController extends Controller
{
    public function index(): View
    {
        return view('public.ruc.index');
    }

    public function buscar(Request $request, RucBuscador $buscador): RedirectResponse
    {
        $recaptcha = new Recaptcha;

        $datos = $request->validate([
            'consulta' => ['required', 'string', 'min:3', 'max:255'],
            'recaptcha_token' => [$recaptcha],
        ], [
            'consulta.required' => 'Ingresa un RUC o un nombre para buscar.',
            'consulta.min' => 'Ingresa al menos 3 caracteres.',
        ]);

        try {
            $resultados = $buscador->buscar($datos['consulta']);
        } catch (QueryException $e) {
            Log::error('Error consultando la base auxiliar de RUC: '.$e->getMessage());

            return back()->withInput()->withErrors([
                'consulta' => 'El servicio de consulta no esta disponible en este momento. Intenta mas tarde.',
            ]);
        }

        ConsultaRuc::create([
            'ruc_buscado' => $datos['consulta'],
            'encontrado' => count($resultados) > 0,
            'resultados_count' => count($resultados),
            'razon_social' => count($resultados) === 1 ? $resultados[0]['razon_social'] : null,
            'estado' => count($resultados) === 1 ? $resultados[0]['estado'] : null,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'recaptcha_score' => $recaptcha->score,
        ]);

        return back()->withInput()->with([
            'resultados' => $resultados,
            'buscado' => $datos['consulta'],
        ]);
    }

    /**
     * Vista previa en vivo mientras se tipea -mismo buscador que
     * buscar(), pero sin guardar en ConsultaRuc: esa tabla queda para la
     * búsqueda que la persona realmente decide hacer (botón "Buscar" o
     * Enter), no cada letra que tipeó en el camino.
     */
    public function buscarEnVivo(Request $request, RucBuscador $buscador): JsonResponse
    {
        $recaptcha = new Recaptcha;

        $datos = $request->validate([
            'consulta' => ['required', 'string', 'min:3', 'max:255'],
            'recaptcha_token' => [$recaptcha],
        ]);

        try {
            $resultados = $buscador->buscar($datos['consulta']);
        } catch (QueryException $e) {
            Log::error('Error consultando la base auxiliar de RUC: '.$e->getMessage());

            return response()->json(['error' => 'El servicio de consulta no esta disponible en este momento.'], 503);
        }

        return response()->json(['resultados' => $resultados, 'buscado' => $datos['consulta']]);
    }
}
