<?php

namespace Tests\Feature\Public;

use App\Services\RucBuscador;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RucConsultaTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pagina_de_consulta_carga(): void
    {
        $this->get(route('publico.ruc.index'))
            ->assertOk()
            ->assertSee('Consulta de RUC');
    }

    public function test_requiere_la_consulta(): void
    {
        $this->from(route('publico.ruc.index'))
            ->post(route('publico.ruc.buscar'), [
                'consulta' => '',
                'recaptcha_token' => 'token-de-prueba',
            ])
            ->assertRedirect(route('publico.ruc.index'))
            ->assertSessionHasErrors('consulta');
    }

    public function test_sin_secret_key_configurada_el_recaptcha_se_omite(): void
    {
        config(['services.recaptcha.secret_key' => null]);

        $this->mock(RucBuscador::class)
            ->shouldReceive('buscar')
            ->once()
            ->andReturn([]);

        $this->from(route('publico.ruc.index'))
            ->post(route('publico.ruc.buscar'), [
                'consulta' => '80012345',
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
                'consulta' => '80012345',
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
                'consulta' => '80012345',
                'recaptcha_token' => 'token-de-bot',
            ])
            ->assertRedirect(route('publico.ruc.index'))
            ->assertSessionHasErrors('recaptcha_token');
    }

    public function test_busqueda_por_ruc_exacto_muestra_un_resultado(): void
    {
        config(['services.recaptcha.secret_key' => 'secret-de-prueba']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true, 'score' => 0.9]),
        ]);

        $this->mock(RucBuscador::class)
            ->shouldReceive('buscar')
            ->with('80012345')
            ->once()
            ->andReturn([[
                'ruc' => '80012345',
                'digito_verificador' => '6',
                'ruc_completo' => '80012345-6',
                'razon_social' => 'Empresa de Prueba S.A.',
                'estado' => 'ACTIVO',
            ]]);

        $response = $this->from(route('publico.ruc.index'))
            ->post(route('publico.ruc.buscar'), [
                'consulta' => '80012345',
                'recaptcha_token' => 'token-valido',
            ]);

        $response->assertRedirect(route('publico.ruc.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('resultados.0.razon_social', 'Empresa de Prueba S.A.');

        $this->get(route('publico.ruc.index'))
            ->assertOk()
            ->assertSee('Empresa de Prueba S.A.')
            ->assertSee('80012345-6');

        $this->assertDatabaseHas('consultas_ruc', [
            'ruc_buscado' => '80012345',
            'encontrado' => true,
            'resultados_count' => 1,
            'razon_social' => 'Empresa de Prueba S.A.',
            'recaptcha_score' => 0.9,
        ]);
    }

    public function test_busqueda_por_nombre_muestra_varias_coincidencias(): void
    {
        config(['services.recaptcha.secret_key' => 'secret-de-prueba']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true, 'score' => 0.9]),
        ]);

        $this->mock(RucBuscador::class)
            ->shouldReceive('buscar')
            ->with('Empresa')
            ->once()
            ->andReturn([
                ['ruc' => '1', 'digito_verificador' => '1', 'ruc_completo' => '1-1', 'razon_social' => 'Empresa Uno S.A.', 'estado' => 'ACTIVO'],
                ['ruc' => '2', 'digito_verificador' => '2', 'ruc_completo' => '2-2', 'razon_social' => 'Empresa Dos S.R.L.', 'estado' => 'ACTIVO'],
            ]);

        $response = $this->from(route('publico.ruc.index'))
            ->post(route('publico.ruc.buscar'), [
                'consulta' => 'Empresa',
                'recaptcha_token' => 'token-valido',
            ]);

        $response->assertSessionHasNoErrors();

        // El conteo ("2 coincidencias") y el armado de la lista ahora los
        // arma Alpine en el navegador a partir del JSON embebido en
        // x-data -lo que importa verificar acá es que los dos resultados
        // realmente lleguen a la vista, no el texto ya renderizado-.
        $this->get(route('publico.ruc.index'))
            ->assertOk()
            ->assertSee('Empresa Uno S.A.')
            ->assertSee('Empresa Dos S.R.L.');

        $this->assertDatabaseHas('consultas_ruc', [
            'ruc_buscado' => 'Empresa',
            'encontrado' => true,
            'resultados_count' => 2,
            'razon_social' => null,
        ]);
    }

    public function test_sin_resultados_muestra_mensaje(): void
    {
        config(['services.recaptcha.secret_key' => 'secret-de-prueba']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true, 'score' => 0.9]),
        ]);

        $this->mock(RucBuscador::class)
            ->shouldReceive('buscar')
            ->once()
            ->andReturn([]);

        $this->from(route('publico.ruc.index'))
            ->post(route('publico.ruc.buscar'), [
                'consulta' => '99999999',
                'recaptcha_token' => 'token-valido',
            ])
            ->assertRedirect(route('publico.ruc.index'));

        $this->get(route('publico.ruc.index'))
            ->assertOk()
            ->assertSee('No se encontraron resultados');
    }

    public function test_la_busqueda_en_vivo_devuelve_json_sin_guardar_en_consultas_ruc(): void
    {
        config(['services.recaptcha.secret_key' => 'secret-de-prueba']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true, 'score' => 0.9]),
        ]);

        $this->mock(RucBuscador::class)
            ->shouldReceive('buscar')
            ->with('Empresa')
            ->once()
            ->andReturn([
                ['ruc' => '1', 'digito_verificador' => '1', 'ruc_completo' => '1-1', 'razon_social' => 'Empresa Uno S.A.', 'estado' => 'ACTIVO'],
            ]);

        $response = $this->getJson(route('publico.ruc.buscar-vivo', [
            'consulta' => 'Empresa',
            'recaptcha_token' => 'token-valido',
        ]));

        $response->assertOk();
        $response->assertJsonPath('resultados.0.razon_social', 'Empresa Uno S.A.');
        $response->assertJsonPath('buscado', 'Empresa');

        // A diferencia de buscar(), esta vista previa no se audita.
        $this->assertDatabaseCount('consultas_ruc', 0);
    }

    public function test_la_busqueda_en_vivo_tambien_exige_recaptcha_valido(): void
    {
        config(['services.recaptcha.secret_key' => 'secret-de-prueba']);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true, 'score' => 0.1]),
        ]);

        $this->mock(RucBuscador::class)->shouldNotReceive('buscar');

        $this->getJson(route('publico.ruc.buscar-vivo', [
            'consulta' => 'Empresa',
            'recaptcha_token' => 'token-de-bot',
        ]))->assertJsonValidationErrors('recaptcha_token');
    }

    public function test_la_busqueda_en_vivo_exige_al_menos_3_caracteres(): void
    {
        $this->mock(RucBuscador::class)->shouldNotReceive('buscar');

        $this->getJson(route('publico.ruc.buscar-vivo', [
            'consulta' => 'ab',
            'recaptcha_token' => 'token',
        ]))->assertJsonValidationErrors('consulta');
    }
}
