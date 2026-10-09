<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tramos de la Patente Comercial segun Ley N 135/91 (modifica Ley N
    // 620/76 - Regimen Tributario para las Municipalidades del interior del
    // pais, Articulo 7). Verificado contra comprobante real de la SET.
    private const TRAMOS = [
        ['monto_desde' => 0, 'monto_hasta' => 1_000_000, 'porcentaje' => 0.00, 'adicional' => 13_800, 'orden' => 1],
        ['monto_desde' => 1_000_000, 'monto_hasta' => 3_000_000, 'porcentaje' => 0.85, 'adicional' => 13_800, 'orden' => 2],
        ['monto_desde' => 3_000_000, 'monto_hasta' => 6_000_000, 'porcentaje' => 0.80, 'adicional' => 34_200, 'orden' => 3],
        ['monto_desde' => 6_000_000, 'monto_hasta' => 30_000_000, 'porcentaje' => 0.55, 'adicional' => 58_200, 'orden' => 4],
        ['monto_desde' => 30_000_000, 'monto_hasta' => 60_000_000, 'porcentaje' => 0.40, 'adicional' => 190_200, 'orden' => 5],
        ['monto_desde' => 60_000_000, 'monto_hasta' => 300_000_000, 'porcentaje' => 0.28, 'adicional' => 310_200, 'orden' => 6],
        ['monto_desde' => 300_000_000, 'monto_hasta' => 600_000_000, 'porcentaje' => 0.22, 'adicional' => 982_200, 'orden' => 7],
        ['monto_desde' => 600_000_000, 'monto_hasta' => 1_800_000_000, 'porcentaje' => 0.20, 'adicional' => 1_642_200, 'orden' => 8],
        ['monto_desde' => 1_800_000_000, 'monto_hasta' => 3_000_000_000, 'porcentaje' => 0.18, 'adicional' => 4_042_200, 'orden' => 9],
        ['monto_desde' => 3_000_000_000, 'monto_hasta' => 6_000_000_000, 'porcentaje' => 0.15, 'adicional' => 6_202_200, 'orden' => 10],
        ['monto_desde' => 6_000_000_000, 'monto_hasta' => 9_000_000_000, 'porcentaje' => 0.13, 'adicional' => 10_702_200, 'orden' => 11],
        ['monto_desde' => 9_000_000_000, 'monto_hasta' => 12_000_000_000, 'porcentaje' => 0.10, 'adicional' => 14_602_200, 'orden' => 12],
        ['monto_desde' => 12_000_000_000, 'monto_hasta' => 15_000_000_000, 'porcentaje' => 0.08, 'adicional' => 17_602_200, 'orden' => 13],
        ['monto_desde' => 15_000_000_000, 'monto_hasta' => 999_999_999_999_999, 'porcentaje' => 0.05, 'adicional' => 20_002_200, 'orden' => 14],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patente_comercial_tramos', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto_desde', 18, 0);
            $table->decimal('monto_hasta', 18, 0);
            $table->decimal('porcentaje', 5, 2);
            $table->decimal('adicional', 18, 0);
            $table->unsignedTinyInteger('orden');
            $table->timestamps();
        });

        $ahora = now();
        DB::table('patente_comercial_tramos')->insert(array_map(
            fn (array $tramo) => [...$tramo, 'created_at' => $ahora, 'updated_at' => $ahora],
            self::TRAMOS,
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patente_comercial_tramos');
    }
};
