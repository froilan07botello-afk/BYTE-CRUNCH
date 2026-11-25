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
        //se agregaron los campos necesarios para agregar un metodo de pago en la web
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('metodo_pago', 30)->default('efectivo')->after('estado');
            $table->string('referencia_pago', 100)->nullable()->after('metodo_pago');
            $table->string('codigo_entrega', 10)->nullable()->after('referencia_pago');
            $table->timestamp('entregado_en')->nullable()->after('codigo_entrega');
            $table->string('nota_entrega', 255)->nullable()->after('entregado_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'metodo_pago',
                'referencia_pago',
                'codigo_entrega',
                'entregado_en',
                'nota_entrega',
            ]);
        });
    }
};
