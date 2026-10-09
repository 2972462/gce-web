<?php

namespace Tests\Feature\Public;

use App\Services\RucBuscador;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RucConsultaTest extends TestCase
{
    public function test_la_pagina_de_consulta_carga(): void
    {
        $this->get(route('publico.ruc.index'))
            ->assertOk()
            ->assertSee('Consulta de RUC');
    }

    public function test_requiere_el_numero_de_ruc(): void
    {
        $this->from(route('publico.ruc.index'))
            ->post(route('publico.ruc.buscar'), [
                'ruc' => '',
                'recaptcha_token' => 'token-de-prueba',
            ])
            ->assertRedirect(route('publico.ruc.index'))
            ->assertSessionHasErrors('ruc');
    }

    public function test_sin_secret_key_configurada_el_recaptcha_se_omite(): void
    {
        config(['services.recaptcha.secret_key' => null]);

        $this->mock(RucBuscador::class)
            ->shouldReceive('buscar')
            ->once()
            ->andReturn(null);

        $this->from(route('publico.ruc.index'))
            ->post(route('publico.ruc.buscar'), [
                'ruc' => '80012345',
                'recaptcha_token' => 'cualquier-cosa',
            ])
            ->assertRedirect(route('publico.ruc.index'))
            ->assertSessionDoesntHaveErrors();
    }

    public function test_recaptcha_rechazado_por_google_rechaza_la_busqueda(): void
    {
        config(['services.recaptcha.secret_key' => 'secret-de-prueba']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => false]),
        ]);

        $this->mock(RucBuscador::class)->shouldNotReceive('buscar');

        $this->from(route('publico.ruc.index'))
            ->post(route('publico.ruc.buscar'), [
                'ruc' => '80012345',
                'recaptcha_token' => 'token-invalido',
            ])
            ->assertRedirect(route('publico.ruc.index'))
            ->assertSessionHasErrors('recaptcha_token');
    }

    public function test_recaptcha_con_score_bajo_rechaza_la_busqueda(): void
    {
        config(['services.recaptcha.secret_key' => 'secret-de-prueba']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true, 'score' => 0.2]),
        ]);

        $this->mock(RucBuscador::class)->shouldNotReceive('buscar');

        $this->from(route('publico.ruc.index'))
            ->post(route('publico.ruc.buscar'), [
                'ruc' => '80012345',
                'recaptcha_token' => 'token-de-bot',
            ])
            ->assertRedirect(route('publico.ruc.index'))
            ->assertSessionHasErrors('recaptcha_token');
    }

    public function test_recaptcha_valido_y_ruc_encontrado_muestra_resultado(): void
    {
        config(['services.recaptcha.secret_key' => 'secret-de-prueba']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true, 'score' => 0.9]),
        ]);

        $this->mock(RucBuscador::class)
            ->shouldReceive('buscar')
            ->with('80012345')
            ->once()
            ->andReturn([
                'ruc' => '80012345',
                'digito_verificador' => '6',
                'ruc_completo' => '80012345-6',
                'razon_social' => 'Empresa de Prueba S.A.',
                'estado' => 'ACTIVO',
            ]);

        $response = $this->from(route('publico.ruc.index'))
            ->post(route('publico.ruc.buscar'), [
                'ruc' => '80012345',
                'recaptcha_token' => 'token-valido',
            ]);

        $response->assertRedirect(route('publico.ruc.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('resultado.razon_social', 'Empresa de Prueba S.A.');

        $this->get(route('publico.ruc.index'))
            ->assertOk()
            ->assertSee('Empresa de Prueba S.A.')
            ->assertSee('80012345-6');
    }

    public function test_ruc_no_encontrado_muestra_mensaje(): void
    {
        config(['services.recaptcha.secret_key' => 'secret-de-prueba']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true, 'score' => 0.9]),
        ]);

        $this->mock(RucBuscador::class)
            ->shouldReceive('buscar')
            ->once()
            ->andReturn(null);

        $this->from(route('publico.ruc.index'))
            ->post(route('publico.ruc.buscar'), [
                'ruc' => '99999999',
                'recaptcha_token' => 'token-valido',
            ])
            ->assertRedirect(route('publico.ruc.index'));

        $this->get(route('publico.ruc.index'))
            ->assertOk()
            ->assertSee('No se encontró ningún RUC');
    }
}
