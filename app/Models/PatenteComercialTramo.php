<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatenteComercialTramo extends Model
{
    protected $fillable = [
        'monto_desde',
        'monto_hasta',
        'porcentaje',
        'adicional',
        'orden',
    ];

    public static function calcular(float $monto): array
    {
        $tramo = self::where('monto_desde', '<=', $monto)
            ->where('monto_hasta', '>', $monto)
            ->orderBy('orden')
            ->first()
            ?? self::orderByDesc('orden')->first();

        $excedente = max(0, $monto - $tramo->monto_desde);
        $impuesto = round($tramo->adicional + $excedente * $tramo->porcentaje / 100);
        $semestre1 = floor($impuesto / 2);
        $semestre2 = $impuesto - $semestre1;

        return [
            'tramo' => $tramo,
            'excedente' => $excedente,
            'impuesto' => $impuesto,
            'semestre1' => $semestre1,
            'semestre2' => $semestre2,
        ];
    }
}
