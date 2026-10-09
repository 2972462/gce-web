<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('consultas_ruc', function (Blueprint $table) {
            $table->unsignedInteger('resultados_count')->default(0)->after('encontrado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultas_ruc', function (Blueprint $table) {
            $table->dropColumn('resultados_count');
        });
    }
};
