<?php

namespace Tests\Unit;

use App\Services\RucBuscador;
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
}
