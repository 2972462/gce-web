<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RucBuscador
{
    public function buscar(string $ruc): ?array
    {
        $ruc = preg_replace('/\D/', '', $ruc);

        if ($ruc === '') {
            return null;
        }

        $filas = DB::connection('auxiliar')->select('CALL fn_ruc(?)', [$ruc]);
        $fila = $filas[0] ?? null;

        if (! $fila) {
            return null;
        }

        return [
            'ruc' => $fila->ruc,
            'digito_verificador' => $fila->digito_verificador,
            'ruc_completo' => $fila->digito_verificador !== null && $fila->digito_verificador !== ''
                ? "{$fila->ruc}-{$fila->digito_verificador}"
                : $fila->ruc,
            'razon_social' => $fila->razon_social,
            'estado' => $fila->estado,
        ];
    }

    /**
     * Las personas fisicas vienen de la base como "APELLIDO/S, NOMBRE/S"
     * (formato de registro oficial); las personas juridicas no tienen
     * coma, son solo el nombre de la empresa tal cual. Para mostrar algo
     * mas natural de leer, se invierte solo cuando hay coma.
     */
    public static function nombreLegible(string $razonSocial): string
    {
        if (! str_contains($razonSocial, ',')) {
            return $razonSocial;
        }

        [$apellido, $nombre] = array_map('trim', explode(',', $razonSocial, 2));

        return trim("{$nombre} {$apellido}");
    }
}
