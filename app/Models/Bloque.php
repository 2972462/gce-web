<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bloque extends Model
{
    public const TIPOS = [
        'texto' => 'Texto',
        'imagen' => 'Imagen',
        'tarjeta' => 'Tarjeta de servicio',
        'boton' => 'Boton',
    ];

    protected $fillable = [
        'seccion_id',
        'tipo',
        'orden',
        'contenido',
    ];

    protected $casts = [
        'contenido' => 'array',
    ];

    public function seccion(): BelongsTo
    {
        return $this->belongsTo(Seccion::class);
    }

    public function moveUp(): void
    {
        $this->swapOrdenWith(
            static::where('seccion_id', $this->seccion_id)
                ->where('orden', '<', $this->orden)
                ->orderByDesc('orden')
                ->first()
        );
    }

    public function moveDown(): void
    {
        $this->swapOrdenWith(
            static::where('seccion_id', $this->seccion_id)
                ->where('orden', '>', $this->orden)
                ->orderBy('orden')
                ->first()
        );
    }

    protected function swapOrdenWith(?self $otro): void
    {
        if (! $otro) {
            return;
        }

        [$this->orden, $otro->orden] = [$otro->orden, $this->orden];
        $this->save();
        $otro->save();
    }
}
