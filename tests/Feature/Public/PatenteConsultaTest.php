<?php

namespace Tests\Feature\Public;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
            ])
            ->assertRedirect(route('publico.patente.index'))
            ->assertSessionHasErrors('monto');
    }

    public function test_rechaza_sin_monto(): void
    {
        $this->from(route('publico.patente.index'))
            ->post(route('publico.patente.calcular'), [])
            ->assertRedirect(route('publico.patente.index'))
            ->assertSessionHasErrors('monto');
    }

    public function test_calculo_exitoso_muestra_el_resultado(): void
    {
        $response = $this->from(route('publico.patente.index'))
            ->post(route('publico.patente.calcular'), [
                'monto' => 2_000_000,
            ]);

        $response->assertRedirect(route('publico.patente.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('resultado.impuesto', 22_300.0);

        $this->get(route('publico.patente.index'))
            ->assertOk()
            ->assertSee('22.300');
    }
}
