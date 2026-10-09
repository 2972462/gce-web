<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = [
        'logo_izquierdo_path',
        'logo_derecho_path',
    ];

    public static function actual(): self
    {
        return static::query()->firstOrCreate([]);
    }

    public function logoIzquierdoUrl(): string
    {
        return $this->logo_izquierdo_path
            ? Storage::disk('public')->url($this->logo_izquierdo_path)
            : asset('images/logo-gce.png');
    }

    public function logoDerechoUrl(): ?string
    {
        return $this->logo_derecho_path
            ? Storage::disk('public')->url($this->logo_derecho_path)
            : null;
    }
}
