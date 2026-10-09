<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seccion extends Model
{
    protected $table = 'secciones';

    protected $fillable = [
        'pagina_id',
        'clave',
        'titulo',
        'orden',
    ];

    public function pagina(): BelongsTo
    {
        return $this->belongsTo(Pagina::class);
    }

    public function bloques(): HasMany
    {
        return $this->hasMany(Bloque::class)->orderBy('orden');
    }

    public function moveUp(): void
    {
        $this->swapOrdenWith(
            static::where('pagina_id', $this->pagina_id)
                ->where('orden', '<', $this->orden)
                ->orderByDesc('orden')
                ->first()
        );
    }

    public function moveDown(): void
    {
        $this->swapOrdenWith(
            static::where('pagina_id', $this->pagina_id)
                ->where('orden', '>', $this->orden)
                ->orderBy('orden')
                ->first()
        );
    }

    protected function swapOrdenWith(?self $otra): void
    {
        if (! $otra) {
            return;
        }

        [$this->orden, $otra->orden] = [$otra->orden, $this->orden];
        $this->save();
        $otra->save();
    }
}
