<?php

namespace Tests\Unit;

use App\Services\RucBuscador;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RucBuscadorTest extends TestCase
{
    public function test_invierte_apellido_nombre_cuando_hay_coma(): void
    {
        $this->assertSame(
            'ANTONIO RODRIGUEZ ARIAS',
            RucBuscador::nombreLegible('RODRIGUEZ ARIAS, ANTONIO')
        );
    }

    public function test_deja_igual_una_razon_social_de_empresa_sin_coma(): void
    {
        $this->assertSame(
            'EMPRESA DE PRUEBA S.A.',
            RucBuscador::nombreLegible('EMPRESA DE PRUEBA S.A.')
        );
    }

    public function test_un_texto_solo_numerico_busca_por_fn_ruc(): void
    {
        DB::shouldReceive('connection')
            ->with('auxiliar')
            ->andReturnSelf();
        DB::shouldReceive('select')
            ->once()
            ->with('CALL fn_ruc(?)', ['80012345'])
            ->andReturn([]);

        (new RucBuscador)->buscar('80012345');
    }

    public function test_un_texto_con_letras_busca_por_fn_razon_social_exigiendo_todas_las_palabras(): void
    {
        DB::shouldReceive('connection')
            ->with('auxiliar')
            ->andReturnSelf();
        DB::shouldReceive('select')
            ->once()
            ->with('CALL fn_razon_social(?)', ['+Empresa +Uno'])
            ->andReturn([]);

        (new RucBuscador)->buscar('Empresa Uno');
    }

    public function test_corta_los_resultados_de_nombre_en_20(): void
    {
        $filas = array_map(fn (int $i) => (object) [
            'ruc' => (string) $i,
            'digito_verificador' => '1',
            'razon_social' => "Empresa {$i}",
            'estado' => 'ACTIVO',
        ], range(1, 50));

        DB::shouldReceive('connection')->with('auxiliar')->andReturnSelf();
        DB::shouldReceive('select')->once()->andReturn($filas);

        $resultado = (new RucBuscador)->buscar('Empresa');

        $this->assertCount(20, $resultado);
    }
}
