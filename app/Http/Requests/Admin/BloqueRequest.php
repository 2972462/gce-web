<?php

namespace App\Http\Requests\Admin;

use App\Models\Bloque;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BloqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo' => ['required', Rule::in(array_keys(Bloque::TIPOS))],
            ...$this->reglasDeContenido($this->input('tipo')),
        ];
    }

    protected function reglasDeContenido(?string $tipo): array
    {
        return match ($tipo) {
            'texto' => [
                'contenido.titulo' => ['nullable', 'string', 'max:255'],
                'contenido.cuerpo' => ['required', 'string'],
            ],
            'imagen' => [
                'contenido.url' => ['required', 'string', 'max:2048'],
                'contenido.alt' => ['required', 'string', 'max:255'],
                'contenido.caption' => ['nullable', 'string', 'max:255'],
            ],
            'tarjeta' => [
                'contenido.icono' => ['nullable', 'string', 'max:100'],
                'contenido.titulo' => ['required', 'string', 'max:255'],
                'contenido.descripcion' => ['required', 'string'],
                'contenido.link' => ['nullable', 'string', 'max:2048'],
            ],
            'boton' => [
                'contenido.texto' => ['required', 'string', 'max:100'],
                'contenido.url' => ['required', 'string', 'max:2048'],
                'contenido.estilo' => ['required', Rule::in(['primario', 'secundario'])],
            ],
            default => [],
        };
    }
}
