<?php

namespace Tests\Unit;

use App\Models\PatenteComercialTramo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatenteComercialTramoTest extends TestCase
{
    use RefreshDatabase;

    public function test_monto_en_el_primer_tramo_paga_el_minimo_fijo(): void
    {
        $resultado = PatenteComercialTramo::calcular(500_000);

        $this->assertSame(13_800.0, $resultado['impuesto']);
    }

    public function test_monto_en_el_segundo_tramo_se_reparte_en_cuotas_iguales(): void
    {
        $resultado = PatenteComercialTramo::calcular(2_000_000);

        $this->assertSame(22_300.0, $resultado['impuesto']);
        $this->assertSame(11_150.0, $resultado['semestre1']);
        $this->assertSame(11_150.0, $resultado['semestre2']);
    }

    public function test_impuesto_impar_reparte_el_resto_en_la_segunda_cuota(): void
    {
        $resultado = PatenteComercialTramo::calcular(1_001_000);

        $this->assertSame(13_809.0, $resultado['impuesto']);
        $this->assertSame(6_904.0, $resultado['semestre1']);
        $this->assertSame(6_905.0, $resultado['semestre2']);
        $this->assertSame(13_809.0, $resultado['semestre1'] + $resultado['semestre2']);
    }

    public function test_caso_de_regresion_550_millones(): void
    {
        $resultado = PatenteComercialTramo::calcular(550_000_000);

        $this->assertSame(1_532_200.0, $resultado['impuesto']);
        $this->assertSame(982_200.0, (float) $resultado['tramo']->adicional);
    }

    public function test_caso_de_regresion_600_millones_borde_de_tramo(): void
    {
        $resultado = PatenteComercialTramo::calcular(600_000_000);

        $this->assertSame(1_642_200.0, $resultado['impuesto']);
        $this->assertSame(1_642_200.0, (float) $resultado['tramo']->adicional);
    }

    public function test_monto_en_el_ultimo_tramo_sin_techo(): void
    {
        $resultado = PatenteComercialTramo::calcular(20_000_000_000);

        $this->assertSame(20_002_200 + (20_000_000_000 - 15_000_000_000) * 0.05 / 100, $resultado['impuesto']);
    }
}
