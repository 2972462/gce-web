<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pagina extends Model
{
    protected $fillable = [
        'slug',
        'titulo',
    ];

    public function secciones(): HasMany
    {
        return $this->hasMany(Seccion::class)->orderBy('orden');
    }
}
