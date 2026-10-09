<?php

namespace Tests\Feature\Public;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PatenteConsultaTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pagina_carga(): void
    {
        $this->get(route('publico.patente.index'))
            ->assertOk()
            ->assertSee('Cálculo de Patente Comercial');
    }

    public function test_rechaza_monto_negativo(): void
    {
        $this->from(route('publico.patente.index'))
            ->post(route('publico.patente.calcular'), [
                'monto' => -100,
                'g-recaptcha-response' => 'token',
            ])
            ->assertRedirect(route('publico.patente.index'))
            ->assertSessionHasErrors('monto');
    }

    public function test_rechaza_sin_monto(): void
    {
        $this->from(route('publico.patente.index'))
            ->post(route('publico.patente.calcular'), [
                'g-recaptcha-response' => 'token',
            ])
            ->assertRedirect(route('publico.patente.index'))
            ->assertSessionHasErrors('monto');
    }

    public function test_recaptcha_invalido_rechaza_el_calculo(): void
    {
        config(['services.recaptcha.secret_key' => 'secret-de-prueba']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => false]),
        ]);

        $this->from(route('publico.patente.index'))
            ->post(route('publico.patente.calcular'), [
                'monto' => 2_000_000,
                'g-recaptcha-response' => 'token-invalido',
            ])
            ->assertRedirect(route('publico.patente.index'))
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    public function test_calculo_exitoso_muestra_el_resultado(): void
    {
        config(['services.recaptcha.secret_key' => 'secret-de-prueba']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true]),
        ]);

        $response = $this->from(route('publico.patente.index'))
            ->post(route('publico.patente.calcular'), [
                'monto' => 2_000_000,
                'g-recaptcha-response' => 'token-valido',
            ]);

        $response->assertRedirect(route('publico.patente.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('resultado.impuesto', 22_300.0);

        $this->get(route('publico.patente.index'))
            ->assertOk()
            ->assertSee('22.300');
    }
}
