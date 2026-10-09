<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RucBuscador
{
    /**
     * Busca por RUC (solo numeros/puntos/guiones) o por nombre/razon
     * social (si el texto tiene letras). Siempre devuelve una lista:
     * 0 filas si no hay coincidencias, 1 en una busqueda exacta por RUC,
     * hasta 200 en una busqueda por nombre.
     */
    public function buscar(string $texto): array
    {
        $soloNumeros = preg_replace('/[.\-\s]/', '', $texto);

        if ($soloNumeros !== '' && ctype_digit($soloNumeros)) {
            return $this->buscarPorRuc($soloNumeros);
        }

        return $this->buscarPorRazonSocial($texto);
    }

    private function buscarPorRuc(string $ruc): array
    {
        $filas = DB::connection('auxiliar')->select('CALL fn_ruc(?)', [$ruc]);

        return array_map([$this, 'mapearFila'], $filas);
    }

    private function buscarPorRazonSocial(string $texto): array
    {
        $texto = trim($texto);

        if ($texto === '') {
            return [];
        }

        $filas = DB::connection('auxiliar')->select('CALL fn_razon_social(?)', [$texto]);

        return array_map([$this, 'mapearFila'], $filas);
    }

    private function mapearFila(object $fila): array
    {
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
