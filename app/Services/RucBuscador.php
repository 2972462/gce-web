<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RucBuscador
{
    /** Tope de coincidencias a mostrar en una busqueda por nombre (fn_razon_social trae hasta 200). */
    public const MAX_RESULTADOS_NOMBRE = 20;

    /**
     * Busca por RUC (solo numeros/puntos/guiones) o por nombre/razon
     * social (si el texto tiene letras). Siempre devuelve una lista:
     * 0 filas si no hay coincidencias, 1 en una busqueda exacta por RUC,
     * hasta MAX_RESULTADOS_NOMBRE en una busqueda por nombre.
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

        $filas = DB::connection('auxiliar')->select('CALL fn_razon_social(?)', [$this->comoConsultaBooleana($texto)]);

        return array_map([$this, 'mapearFila'], array_slice($filas, 0, self::MAX_RESULTADOS_NOMBRE));
    }

    /**
     * fn_razon_social usa MATCH ... AGAINST (... IN BOOLEAN MODE): sin
     * operadores, MySQL junta las palabras con OR, asi que buscar
     * "roberto rodriguez arias" trae cualquier fila con solo "roberto"
     * (nombre muy comun) y devuelve el tope de 200 filas sin que
     * ninguna sea realmente relevante. Anteponiendo "+" a cada palabra
     * se le pide que coincidan todas (en cualquier orden). El "*" al
     * final de cada una pide ademas una coincidencia por prefijo, no
     * exacta -asi "muni irala" encuentra "MUNICIPALIDAD ... IRALA ...",
     * aunque "muni" no sea una palabra completa del registro-.
     */
    private function comoConsultaBooleana(string $texto): string
    {
        $palabras = preg_split('/\s+/', trim($texto), -1, PREG_SPLIT_NO_EMPTY);

        return implode(' ', array_map(fn (string $palabra) => '+'.$palabra.'*', $palabras));
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
