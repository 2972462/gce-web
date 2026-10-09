<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * reCAPTCHA v3 (invisible): a diferencia de v2, Google no devuelve un
 * simple "si/no" sino un puntaje de 0 a 1 que estima que tan humana fue
 * la interaccion. Un puntaje bajo no significa necesariamente un bot,
 * asi que el umbral queda relativamente permisivo para no bloquear
 * gente real en una herramienta publica y gratuita.
 */
class Recaptcha implements ValidationRule
{
    private const UMBRAL_MINIMO = 0.5;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secretKey = config('services.recaptcha.secret_key');

        if (! $secretKey) {
            Log::warning('reCAPTCHA sin configurar (RECAPTCHA_SECRET_KEY vacio): se omite la verificacion.');

            return;
        }

        if (! is_string($value) || $value === '') {
            $fail('No pudimos verificar que sos una persona. Recarga la pagina e intenta de nuevo.');

            return;
        }

        $respuesta = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $value,
        ]);

        if (! $respuesta->successful() || ! ($respuesta->json('success') === true)) {
            $fail('No pudimos verificar que sos una persona. Recarga la pagina e intenta de nuevo.');

            return;
        }

        if ((float) $respuesta->json('score', 0) < self::UMBRAL_MINIMO) {
            $fail('No pudimos verificar que sos una persona. Recarga la pagina e intenta de nuevo.');
        }
    }
}
