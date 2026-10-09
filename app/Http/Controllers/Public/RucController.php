<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ConsultaRuc;
use App\Rules\Recaptcha;
use App\Services\RucBuscador;
use Illuminate\Database\QueryException;
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
            'ruc' => ['required', 'string', 'regex:/^[0-9][0-9.\-]{0,17}[0-9]$/'],
            'recaptcha_token' => [$recaptcha],
        ], [
            'ruc.regex' => 'Ingresa un numero de RUC valido.',
        ]);

        try {
            $resultado = $buscador->buscar($datos['ruc']);
        } catch (QueryException $e) {
            Log::error('Error consultando la base auxiliar de RUC: '.$e->getMessage());

            return back()->withInput()->withErrors([
                'ruc' => 'El servicio de consulta no esta disponible en este momento. Intenta mas tarde.',
            ]);
        }

        ConsultaRuc::create([
            'ruc_buscado' => $datos['ruc'],
            'encontrado' => $resultado !== null,
            'razon_social' => $resultado['razon_social'] ?? null,
            'estado' => $resultado['estado'] ?? null,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'recaptcha_score' => $recaptcha->score,
        ]);

        return back()->withInput()->with([
            'resultado' => $resultado,
            'buscado' => $datos['ruc'],
        ]);
    }
}
