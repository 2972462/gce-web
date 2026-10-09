<?php

namespace Tests\Feature\Public;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatenteConsultaTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pagina_carga_y_trae_la_escala_de_tramos(): void
    {
        $this->get(route('publico.patente.index'))
            ->assertOk()
            ->assertSee('Cálculo de Patente Comercial')
            ->assertSee('Escala de tramos vigente')
            ->assertSee('patenteCalculadora', false);
    }
}
