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
        Schema::rename('detalle_pedidos_', 'detalle_pedidos');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('detalle_pedidos', 'detalle_pedidos_');
    }
};
