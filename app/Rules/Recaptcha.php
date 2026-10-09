<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secretKey = config('services.recaptcha.secret_key');

        if (! $secretKey) {
            Log::warning('reCAPTCHA sin configurar (RECAPTCHA_SECRET_KEY vacio): se omite la verificacion.');

            return;
        }

        if (! is_string($value) || $value === '') {
            $fail('Completa el captcha para continuar.');

            return;
        }

        $respuesta = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $value,
        ]);

        if (! $respuesta->successful() || ! ($respuesta->json('success') === true)) {
            $fail('No pudimos verificar el captcha. Intenta nuevamente.');
        }
    }
}
