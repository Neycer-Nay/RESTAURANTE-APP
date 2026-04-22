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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_caja')->constrained('cajas', 'id');
            $table->foreignId('id_usuario')->constrained('users');
            $table->foreignId('id_cliente')->nullable()->constrained('clientes', 'id')->nullOnDelete();
            $table->datetime('fecha_venta')->useCurrent();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
