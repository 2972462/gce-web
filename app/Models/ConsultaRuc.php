<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaRuc extends Model
{
    protected $table = 'consultas_ruc';

    protected $fillable = [
        'ruc_buscado',
        'encontrado',
        'resultados_count',
        'razon_social',
        'estado',
        'ip',
        'user_agent',
        'recaptcha_score',
    ];

    protected $casts = [
        'encontrado' => 'boolean',
        'recaptcha_score' => 'float',
    ];
}
